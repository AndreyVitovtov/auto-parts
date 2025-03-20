<?php

namespace App\Controllers;

use App\Models\Product;

class Category extends Controller
{
	public function index($category = null): void
	{
		if (is_string($category)) {
			$category = (new \App\Models\Category())->getOneObject(['slug' => $category]);
			$categories = (new \App\Models\Category())->query("
				SELECT * 
				FROM `categories`
				WHERE `parent_id` = :parentId
			", [
				'parentId' => $category->id ?? ''
			], true);
		} else {
			$categories = (new \App\Models\Category())->query("
				SELECT * 
				FROM `categories`
				WHERE `parent_id` IS NULL
			", [], true);
		}

		if (empty($categories)) {
			$products = (new Product())->query("
				SELECT p.*, c.`title` AS currencyTitle, c.`code` AS currencyCode
				FROM `products` p,
				     `currencies` c
				WHERE p.`currency_id` = c.`id`
				AND p.`category_id` = :category_id
			", [
				'category_id' => $category->id
			], true);
			$products = array_map(function ($product) {
				return (new Product($product));
			}, $products);
		}

		$this->view('index', [
			'title' => __('home'),
			'categories' => $categories,
			'categoryPath' => (new \App\Models\Category())->getCategoryPath($category->id ?? 0),
			'categoryTitle' => $category->title ?? null,
			'products' => ($products ?? [])
		]);
	}
}