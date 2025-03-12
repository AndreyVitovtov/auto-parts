<?php

namespace App\Controllers;

use App\Models\Currency;

class Product extends Controller
{
	public function index($slug): void
	{
		$product = (new \App\Models\Product())->getOneObject([
			'slug' => $slug
		]);

		$currency = (new Currency())->getOneObject([
			'id' => $product->currency_id
		]);
		$product->currency = $currency->code;

		$this->view('index', [
			'title' => $product->title,
			'product' => $product,
			'categoryPath' => (new \App\Models\Category())->getCategoryPath($product->category_id ?? 0),
		]);
	}
}