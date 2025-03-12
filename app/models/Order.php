<?php

namespace App\Models;

class Order extends Model
{
	protected $table = 'orders';
	protected $fields = [
		'product_id', 'count', 'first_name', 'last_name', 'phone_number', 'city_name', 'warehouses', 'status'
	];
}