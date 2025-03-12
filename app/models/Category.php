<?php

namespace App\Models;

/**
 * @property mixed|null $title
 * @property mixed|null $description
 * @property mixed|string|null $slug
 * @property mixed|null $parent_id
 * @property mixed|string|null $image
 */
class Category extends Model
{
	protected $table = 'categories';
	protected $fields = [
		'parent_id', 'title', 'slug', 'description', 'image'
	];

	public function getCategories($separator = ' → '): \PDO|array
	{
		return $this->query("
			WITH RECURSIVE `category_path` AS (
			    SELECT `id`, `title`, `parent_id`, `title` AS path, `id` AS last_id
			    FROM `categories`
			    WHERE `parent_id` IS NULL
			
			    UNION ALL
			
			    SELECT c.`id`, c.`title`, c.`parent_id`, CONCAT(cp.`path`, :separator, c.`title`), c.`id`
			    FROM `categories` c
	            INNER JOIN `category_path` cp ON c.`parent_id` = cp.`id`
			)
		
			SELECT `path`, `last_id`
			FROM `category_path`
			WHERE `id` NOT IN (
				SELECT DISTINCT `parent_id` 
				FROM `categories` 
				WHERE `parent_id` IS NOT NULL
			)", [
			'separator' => $separator
		], true);
	}

	public function getCategoryPath($categoryId): array
	{
		$path = [];
		$category = $this->query("
			SELECT *
			FROM `categories` 
			WHERE id = :id", [
			'id' => $categoryId
		], true)[0] ?? null;

		while ($category) {
			$path[] = $category;
			$categoryId = $category['parent_id'];

			if ($categoryId) {
				$category = $this->query("
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