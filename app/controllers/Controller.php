<?php

namespace App\Controllers;

class Controller
{

	/* EXAMPLE
			$this->access = [
				'guest' => [
					'index'
				],
				'admin' => [
					'index'
				]
			];

		  $this->forbid = [
			  'guest' => 'ALL'
		  ];
	*/

	protected $access = [];
	protected $forbid = [];

	protected function viewAdmin($template, $params = []): Controller
	{
		if (!empty($this->auth) || !empty($this->access) || !empty($this->forbid)) {
			$trace = debug_backtrace();
			$method = $trace[1]['function'] ?? null;
			if (!empty($this->access) || !empty($this->forbid)) {
				if (!is_null($method)) {
					$this->checkAccess($method);
				}
			}

			if (!empty($this->auth)) {
				if (!is_null($method) && in_array($method, $this->auth)) {
					$this->checkAuth();
				}
			}
		}

		$params['template'] = strtolower(array_reverse(preg_split('/[\/\\\\]/', get_called_class()))[0]) . '/' .
			$template;
		$params['theme'] = theme();
		extract(getSessionParams());
		extract($params);
		$template = ucfirst($template);
		require_once 'app/templates/mainAdmin.php';
		return $this;
	}

	protected function view($template, $params = []): Controller
	{
		if (!empty($this->auth) || !empty($this->access) || !empty($this->forbid)) {
			$trace = debug_backtrace();
			$method = $trace[1]['function'] ?? null;
			if (!empty($this->access) || !empty($this->forbid)) {
				if (!is_null($method)) {
					$this->checkAccess($method);
				}
			}

			if (!empty($this->auth)) {
				if (!is_null($method) && in_array($method, $this->auth)) {
					$this->checkAuth();
				}
			}
		}

		$params['template'] = strtolower(array_reverse(preg_split('/[\/\\\\]/', get_called_class()))[0]) . '/' .
			$template;
		$params['theme'] = theme();
		extract(getSessionParams());
		extract($params);
		$template = ucfirst($template);
		require_once 'app/templates/main.php';
		return $this;
	}

	protected function checkAuth()
	{
		if (!isAuth()) {
			(new Errors)->error403();
		}
	}

	protected function checkAccess($method)
	{
		if (!empty($this->access) && !in_array($method, $this->access[getRole()] ?? [])) {
			(new Errors)->error403();
			die;
		}

		if (isset($this->forbid[getRole()]) &&
			(is_string($this->forbid[getRole()]) && strtoupper($this->forbid[getRole()]) == 'ALL') ||
			(in_array($method, $this->forbid[getRole()] ?? []))) (new Errors)->error403();
	}

	protected function auth(): ?Controller
	{
		if (isAuth()) return $this;
		redirect('/admin/auth');
		return null;
	}

	protected function notAuth(): ?Controller
	{
		if (!isAuth()) return $this;
		redirect('/admin/');
		return null;
	}

	protected function slug($text): string
	{
		$translit = [
			'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z',
			'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r',
			'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'kh', 'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => 'shch',
			'ы' => 'y', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'і' => 'i', 'ї' => 'yi', 'є' => 'ye', 'ґ' => 'g',
			'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh', 'З' => 'Z',
			'И' => 'I', 'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P', 'Р' => 'R',
			'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'Kh', 'Ц' => 'Ts', 'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Shch',
			'Ы' => 'Y', 'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya', 'І' => 'I', 'Ї' => 'Yi', 'Є' => 'Ye', 'Ґ' => 'G'
		];
		$text = strtr($text, $translit);
		$text = mb_strtolower($text, 'UTF-8');
		$text = preg_replace('/[^a-z0-9\s-]/u', '', $text);
		$text = preg_replace('/[\s-]+/', '-', $text);
		return trim($text, '-');
	}
}