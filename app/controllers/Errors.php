<?php

namespace App\Controllers;

class Errors extends Controller
{
	public function error404($isAdmin = false): void
	{
		if ($isAdmin) {
			$this->viewAdmin('404', [
				'title' => 'Page Not Found',
				'pageTitle' => '404'
			]);
		} else {
			$this->view('404', [
				'title' => 'Page Not Found',
				'pageTitle' => '404'
			]);
		}
	}

	public function error403()
	{
		$this->viewAdmin('403', [
			'title' => 'Access denied',
			'pageTitle' => '403'
		]);
	}
}