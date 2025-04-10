<?php

sessionStart();

date_default_timezone_set(TIMEZONE);

if (!empty($_COOKIE['cartProducts'])) {
	$_SESSION['cartProducts'] = (@json_decode($_COOKIE['cartProducts'], true) ?? []);
}

function isDev(): void
{
	if (DEV) {
		ini_set('error_reporting', E_ALL);
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
	} else {
		ini_set('error_reporting', 0);
		ini_set('display_errors', 0);
		ini_set('display_startup_errors', 0);
	}
}

function getControllerAndMethod(): array
{
	$url = array_values(array_filter(explode('/', $_SERVER['REQUEST_URI']), function ($v) {
		return !empty(trim($v));
	}));

	$params = [];

	if (empty($url)) {
		$controllerName = HOME_CONTROLLER;
		$method = 'index';
	} elseif ($url[0] === 'admin') {
		if (!isset($url[1])) {
			$controllerName = 'Main';
			$method = 'index';
		} else {
			$controllerName = ucfirst($url[1]);
			$method = isset($url[2]) && !is_numeric($url[2]) ? $url[2] : 'index';
			unset($url[0], $url[1], $url[2]);
		}
		$isAdmin = true;
	} else {
		$controllerName = ucfirst($url[0]);
		$method = isset($url[1]) && !is_numeric($url[1]) ? $url[1] : 'index';
		unset($url[0], $url[1]);
	}

	if (strpos($controllerName, '?') !== false) {
		[$controllerName, $queryString] = explode('?', $controllerName, 2);
		$params = parseParams($queryString);
	}
	if (strpos($method, '?') !== false) {
		[$method, $queryString] = explode('?', $method, 2);
		$params = array_merge($params, parseParams($queryString));
	}

	$params = array_merge($params, $url);

	global $cName, $cMethod;
	$cName = $controllerName;
	$cMethod = $method;

	return [
		'controllerName' => $controllerName,
		'method' => $method,
		'params' => $params,
		'isAdmin' => $isAdmin ?? false
	];
}

function parseParams($queryString)
{
	return array_reduce(explode('&', $queryString), function ($carry, $item) {
		$parts = explode('=', $item, 2);
		if (count($parts) === 2) {
			$carry[$parts[0]] = $parts[1];
		}
		return $carry;
	}, []);
}

function handleRoute()
{
	isDev();

	extract(getControllerAndMethod());

	$controllerClass = "App\\Controllers\\$controllerName";
	if (!class_exists($controllerClass)) {
		header("HTTP/1.0 404 Not Found");
		(new App\Controllers\Errors)->error404($isAdmin);
		exit;
	}

	$controllerInstance = new $controllerClass();
	if (method_exists($controllerInstance, $method)) {
		$params[] = (new \App\Utility\Request());
		$params = array_filter($params, function ($v) {
			return !empty($v);
		});
		$controllerInstance->$method(...$params);
	} else {
		if (method_exists($controllerInstance, 'index')) {
			$controllerInstance->index(...array_merge($params, [$method]));
		} else {
			header("HTTP/1.0 404 Not Found");
			(new App\Controllers\Errors)->error404($isAdmin);
		}
	}
}

function isAuth(): bool
{
	return !empty($_SESSION['id']);
}

function getRole()
{
	return $_SESSION['role'] ?? 'guest';
}

function assets($path): string
{
	$absolutePath = $_SERVER['DOCUMENT_ROOT'] . '/app/assets/' . $path;
	if (file_exists($absolutePath)) {
		$version = filemtime($absolutePath);
		return BASE_URL . 'app/assets/' . $path . '?v=' . $version;
	} else {
		return BASE_URL . 'app/assets/' . $path;
	}
}

function data($path): string
{
	return $_SERVER['DOCUMENT_ROOT'] . '/app/data/' . $path;
}

function redirect($location, $params = [], $var = true)
{
	if ($var && !empty($params)) setSessionParams($params);
	header("Location: " . $location . (!$var && !empty($params) ? '?' . http_build_query($params) : ''));
	exit;
}

function sessionStart()
{
	session_start();
}

function sessionDestroy()
{
	session_destroy();
}

function sessionUpdate($params = [])
{
	foreach ($params as $k => $v) {
		$_SESSION[$k] = $v;
	}
}

function theme(): string
{
	return $_COOKIE['theme'] ?? 'light';
}

function dd($var)
{
	echo '<pre>';
	var_dump($var);
	echo '</pre>';
	die();
}

function br($count = 1): string
{
	return str_repeat("<br>", $count);
}

function user($param, $alter = null)
{
	return !empty($_SESSION[$param]) ? $_SESSION[$param] : $alter;
}

function menuIsActive($c, $m = null, $bool = false)
{
	global $cName;
	global $cMethod;
	if ($bool) return ($cName == $c && (is_null($m) || $cMethod == $m));
	return ($cName == $c && (is_null($m) || $cMethod == $m) ? 'active' : '');
}

function getCurrentLang()
{
	return $_SESSION['lang'] ?? $_COOKIE['lang'] ?? DEFAULT_LANG;
}

function getLocalization()
{
	global $localization;
	if (!empty($localization)) return $localization;
	$localization = json_decode(file_get_contents('app/data/lang/' . getCurrentLang() . '.json'), true);
	return $localization;
}

function getLanguage($item, $abbr = null): string
{
	return LANGUAGES[($abbr ?? getCurrentLang())][$item] ?? '';
}

function __($str, $params = [])
{
	$localization = getLocalization();
	$text = $localization[$str] ?? $str;
	array_map(function ($k, $v) use (&$text) {
		$text = preg_replace('/\{' . $k . '\}/', $v, $text);
	}, array_keys($params), $params);
	return $text;
}

function getCurrentUrl($encodeBase64 = false): string
{
	return ($encodeBase64 ? base64_encode($_SERVER['REQUEST_URI']) : $_SERVER['REQUEST_URI']);
}

function setSessionParams($params)
{
	$_SESSION['extract'] = $params;
}

function getSessionParams($clear = true)
{
	$extract = $_SESSION['extract'] ?? [];
	if ($clear) clearSessionParams();
	return $extract;
}

function clearSessionParams()
{
	unset($_SESSION['extract']);
}

function checkAccess($access = [], $forbid = []): bool
{
	if ((!empty($access) && !in_array(getRole(), $access)) || (!empty($forbid) && in_array(getRole(), $forbid))) return false;
	return true;
}

function menuItem($title, $icon, $address, $controller, $access = [], $forbid = []): string
{
	if (!checkAccess($access, $forbid)) return '';
	return '<a href="' . $address . '">
        <div class="menu-item ' . menuIsActive($controller) . '">
            <i class="icon-' . $icon . '"></i> ' . __($title) . '
        </div>
    </a>';
}

function menuRoll($title, $icon, $controller, $items = [], $access = [], $forbid = []): string
{
	if (!checkAccess($access, $forbid)) return '';
	$menuItems = '';
	foreach ($items as $item) {
		$menuItems .= '<a href="' . $item['address'] . '" class="' . menuIsActive($controller, $item['method']) . '">
                <div>' . $item['title'] . '</div>
            </a>';
	}
	return '<div class="menu-item">
        <div class="flex-between">
            <span><i class="icon-' . $icon . '"></i> ' . $title . '</span>
            <span class="menu-angle"><i class="icon-angle-right"></i></span>
        </div>
        <div class="menu-roll ' . (menuIsActive($controller, null, true) ? 'activate' : '') . '">
            ' . $menuItems . '
        </div>
    </div>';
}

function encryptData($data, $key): string
{
	$cipher = "AES-256-CBC";
	$iv_length = openssl_cipher_iv_length($cipher);
	$iv = openssl_random_pseudo_bytes($iv_length);
	$encrypted = openssl_encrypt($data, $cipher, $key, OPENSSL_RAW_DATA, $iv);
	return base64_encode($iv . $encrypted);
}

function decryptData($data, $key)
{
	$cipher = "AES-256-CBC";
	$iv_length = openssl_cipher_iv_length($cipher);
	$data = base64_decode($data);
	$iv = substr($data, 0, $iv_length);
	$data = substr($data, $iv_length);
	return openssl_decrypt($data, $cipher, $key, OPENSSL_RAW_DATA, $iv);
}