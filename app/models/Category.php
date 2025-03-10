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
}