<?php

namespace App\Controllers;

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
		$this->view('index', [
			'title' => __('home'),
			'categories' => $categories,
			'categoryPath' => $this->getCategoryPath($category->id ?? 0),
			'categoryTitle' => $category->title ?? null
		]);
	}

	private function getCategoryPath($categoryId): array
	{
		$path = [];
		$category = (new \App\Models\Category())->query("
			SELECT *
			FROM `categories` 
			WHERE id = :id", [
			'id' => $categoryId
		], true)[0] ?? null;

		while ($category) {
			$path[] = $category;
			$categoryId = $category['parent_id'];

			if ($categoryId) {
				$category = (new \App\Models\Category())->query("
					SELECT * 
					FROM `categories` 
					WHERE `id` = :id
				", [
					'id' => $categoryId
				], true)[0] ?? null;
			} else {
				break;
			}
		}
		return array_reverse($path);
	}
}