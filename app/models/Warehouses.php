<?php

namespace App\Models;

class Warehouses extends Model
{
	protected $table = 'warehouses';
	protected $fields = [
		'site_key', 'description', 'description_ru', 'short_address', 'short_address_ru', 'phone',
		'type_of_warehouse', 'ref', 'number', 'city_ref', 'city_description', 'city_description_ru', 'settlement_ref',
		'settlement_description', 'settlement_area_description', 'settlement_regions_description', 'settlement_type_description',
		'settlement_type_description_ru', 'longitude', 'latitude'
	];
}