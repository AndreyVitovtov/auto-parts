<?php

namespace App\Controllers;

use App\Utility\Request;

class Search extends Controller
{
	public function index(Request $request)
	{
		$this->auth()->viewAdmin('index', [
			'title' => 'Search',
			'pageTitle' => 'Searching results: "' . $request->search . '"'
		]);
	}
}