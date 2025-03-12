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
}