<?php

namespace App\Controllers;

use App\Models\Category;
use App\Utility\Request;

class Categories extends Controller
{
	public function add(): void
	{
		$categories = (new Category)->get([], '', 'title');
		$categoryTree = $this->buildCategoryTree($categories);
		$this->auth()->viewAdmin('add', [
			'title' => __('add category'),
			'pageTitle' => __('add category'),
			'categoryTree' => $categoryTree
		]);
	}

	private function buildCategoryTree($categories, $parentId = null): array
	{
		$branch = [];
		foreach ($categories as $category) {
			if ($category['parent_id'] === $parentId) {
				$children = $this->buildCategoryTree($categories, $category['id']);
				if ($children) {
					$category['children'] = $children;
				}
				$branch[] = $category;
			}
		}
		return $branch;
	}

	public function addSave(Request $request): void
	{
		$this->auth();

		$parent = $request->parent;
		$parent = (empty($parent) ? null : $parent);

		$category = new Category();
		$category->title = $request->title;
		$category->description = $request->description;
		$category->slug = $this->slug($request->description);
		$category->parent_id = $parent;
		$category->image = 'sdg';
		$category->insert();

		redirect('/admin/categories/all', [
			'message' => __('category added')
		]);
	}

	public function all(): void
	{
		$this->auth()->viewAdmin('all', [
			'title' => __('categories'),
			'pageTitle' => __('categories'),
			'categories' => []
		]);
	}
}