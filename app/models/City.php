<?php

namespace App\Models;

class City extends Model
{
	protected $table = 'cities';
	protected $fields = [
		'ref', 'name_ua', 'name_ru', 'area_ref', 'settlement_type', 'latitude', 'longitude', 'region', 'region_ua',
		'region_ru', 'index1', 'index2', 'index_coatsu', 'special_cash_check', 'has_warehouse'
	];
}