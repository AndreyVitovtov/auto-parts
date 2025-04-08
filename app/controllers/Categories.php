<?php

namespace App\Controllers;

use App\Models\Category;
use App\Utility\Files;
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

		Files::saveImage('image', 'categories/', $category, '/admin/categories/add');

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
			'categories' => (new \App\Models\Category())->getObjects(),
		]);
	}

	public function edit($id)
	{
		$categories = (new Category)->get([], '', 'title');
		$categoryTree = $this->buildCategoryTree($categories);
		$this->auth()->viewAdmin('edit', [
			'title' => __('edit category'),
			'pageTitle' => __('edit category'),
			'category' => (new \App\Models\Category())->find($id),
			'categoryTree' => $categoryTree
		]);
	}

	public function editSave(Request $request): void
	{
		$this->auth();
		$parent = $request->parent;
		$parent = (empty($parent) ? null : $parent);
		$category = (new Category())->find($request->id);
		$category->title = $request->title;
		$category->description = $request->description;
		$category->slug = $this->slug($request->description);
		$category->parent_id = $parent;

		$image = $_FILES['image'] ?? null;
		if (!empty($image)) {
			if (file_exists('app/assets/images/categories/' . $category->image)) {
				unlink('app/assets/images/categories/' . $category->image);
			}
			Files::saveImage('image', 'categories/', $category, '/admin/categories/edit/' . $category->id);
		}

		$category->update();
		redirect('/admin/categories/all', [
			'message' => __('category updated')
		]);
	}

	public function delete(Request $request): void
	{
		$id = $request->id;
		$category = (new Category())->find($id);
		if (!empty($category->image) && file_exists('app/assets/images/categories/' . $category->image)) {
			unlink('app/assets/images/categories/' . $category->image);
		}
		$category->delete();
		redirect('/admin/categories/all', [
			'message' => __('category deleted')
		]);
	}
}