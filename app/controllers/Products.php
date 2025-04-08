<?php

namespace App\Controllers;

use App\Models\Currency;
use App\Models\Product;
use App\Utility\Files;
use App\Utility\Request;

class Products extends Controller
{
	public function add(): void
	{
		$this->auth()->viewAdmin('add', [
			'title' => __('add product'),
			'pageTitle' => __('add product'),
			'categories' => (new \App\Models\Category())->getCategories(),
			'currencies' => (new Currency())->getObjects()
		]);
	}

	public function addSave(Request $request): void
	{
		$this->auth();
		$product = new Product();
		$product->title = $request->title;
		$product->description = $request->description;
		$product->slug = $this->slug($request->title);
		$product->category_id = $request->category;
		Files::saveImage('image', 'products/', $product, '/admin/products/add');
		$product->price = $request->price;
		$product->currency_id = $request->currency;
		$product->count = $request->count;
		$product->insert();

		redirect('/admin/products/add', [
			'message' => __('product added')
		]);
	}

	public function all(): void
	{
		$categories = (new \App\Models\Category())->getCategories();
		$categories = array_combine(array_column($categories, 'last_id'), $categories);
		$this->auth()->viewAdmin('all', [
			'title' => __('products'),
			'pageTitle' => __('products'),
			'categories' => $categories,
			'products' => (new Product())->query("
				SELECT p.*, c.`code` AS currency, cat.`title` AS category
				FROM `products` p,
				     `currencies`c,
				     `categories` cat
				WHERE p.`currency_id` = c.`id`
				AND p.`category_id` = cat.`id`
			", [], true)
		]);
	}

	public function edit($id): void
	{
		$this->auth()->viewAdmin('edit', [
			'title' => __('edit product'),
			'pageTitle' => __('edit product'),
			'product' => (new Product())->find($id),
			'categories' => (new \App\Models\Category())->getCategories(),
			'currencies' => (new Currency())->getObjects()
		]);
	}

	public function editSave(Request $request): void
	{
		$product = (new Product())->find($request->id);
		$product->title = $request->title;
		$product->description = $request->description;
		$product->slug = $this->slug($request->title);
		$product->category_id = $request->category;
		$product->price = $request->price;
		$product->currency_id = $request->currency;
		$product->count = $request->count;

		$image = $_FILES['image'] ?? null;
		if (!empty($image)) {
			if (!empty($product->image) && file_exists('app/assets/images/products/' . $product->image)) {
				unlink('app/assets/images/products/' . $product->image);
			}
			Files::saveImage('image', 'products/', $product, '/admin/products/edit/' . $product->id);
		}

		$product->update();

		redirect('/admin/products/all', [
			'message' => __('product updated')
		]);
	}

	public function delete(Request $request): void
	{
		$id = $request->id;
		$product = (new Product())->find($id);
		if (!empty($product->image) && file_exists('app/assets/images/categories/' . $product->image)) {
			unlink('app/assets/images/products/' . $product->image);
		}
		$product->delete();
		redirect('/admin/products/all', [
			'message' => __('product deleted')
		]);
	}
}