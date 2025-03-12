<?php

namespace App\Models;

/**
 * @property mixed|null $title
 * @property mixed|null $description
 * @property mixed|string|null $slug
 * @property mixed|null $category_id
 * @property mixed|null $price
 * @property mixed|null $currency_id
 * @property mixed|null $count
 */
class Product extends Model
{
	protected $table = 'products';
	protected $fields = [
		'title', 'slug', 'description', 'image', 'category_id', 'price', 'currency_id', 'count'
	];
}