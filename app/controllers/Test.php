<?php

namespace App\Controllers;

class Test extends Controller
{
	public function index()
	{
		$categories = (new \App\Models\Category())->getCategories();
		dd($categories);
	}
}