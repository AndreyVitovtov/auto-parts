<?php

namespace App\Controllers;

use App\Models\City;
use App\Models\Warehouses;
use App\Utility\Request;

class Order extends Controller
{
	public function index(): void
	{
		$this->view('index', [
			'title' => 'Order',
			'assets' => [
				'js' => [
					'jquery-ui.min.js',
					'jquery.auto-complete.min.js',
					'jquery.mask.min.js',
					'order.js'
				],
				'css' => 'jquery-ui.css'
			]
		]);
	}

	public function getCities(Request $request): void
	{
		$cities = (new City())->query("
			SELECT `ref` AS value, `name_ua` AS label
			FROM `cities`
			WHERE `name_ua` LIKE :name
			ORDER BY label
		", [
			'name' => $request->city . '%'
		], true);

		echo json_encode($cities);
	}

	public function getWarehouses(Request $request): void
	{
		$warehouses = (new Warehouses())->query("
			SELECT `description` AS name
			FROM `warehouses`
			WHERE `city_ref` = :cityRef
			ORDER BY `description`
		", [
			'cityRef' => $request->cityRef ?? ''
		], true);
		echo json_encode(array_column($warehouses, 'name'));
	}
}