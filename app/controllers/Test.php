<?php

namespace App\Controllers;

class Test extends Controller
{
	public function index()
	{
		$categories = (new \App\Models\Category())->get();
		foreach ($categories as $category) {
			$c = new \App\Models\Category();
			$c->find($category['id']);
			$c->slug = $this->slug($category['description']);
			$c->update();
		}
	}
}