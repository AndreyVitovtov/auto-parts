<?php

namespace App\Controllers;

use App\Models\Currency;
use App\Utility\Request;

class Cart extends Controller
{
	public function index(): void
	{
		$this->view('index', [
			'title' => __('cart'),
			'pageTitle' => __('cart'),
			'products' => self::get(true),
			'currency' => (new Currency())->getOneObject(['id' => 1]),
			'assets' => [
				'js' => 'cart.js'
			]
		]);
	}

	public function add(Request $request): void
	{
		if (!in_array($request->id, array_keys($_SESSION['cartProducts'] ?? []))) {
			$_SESSION['cartProducts'][$request->id] = 1;
		}
		setcookie('cartProducts', json_encode($_SESSION['cartProducts']), time() + 3600 * 24 * 30, '/');
		echo json_encode([
			'success' => true,
			'textButton' => __('in cart'),
			'count' => count(self::get())
		]);
	}

	public function changeCountProduct(Request $request): void
	{
		if ($request->count == 0) {
			if (isset($_SESSION['cartProducts'][$request->id])) unset($_SESSION['cartProducts'][$request->id]);
		} else {
			$_SESSION['cartProducts'][$request->id] = $request->count;
		}
		setcookie('cartProducts', json_encode($_SESSION['cartProducts']), time() + 3600 * 24 * 30, '/');
		$id = $request->id;
		$count = $request->count;
		echo json_encode([
			'success' => true,
			'total' => array_sum(array_map(function ($product) use ($id, $count) {
				if ($product->id == $id) return $count * $product->price;
				return $product->countInCart * $product->price;
			}, self::get(true)))
		]);
	}

	public function deleteFromCart(Request $request): void
	{
		if (isset($_SESSION['cartProducts'][$request->id])) unset($_SESSION['cartProducts'][$request->id]);
		setcookie('cartProducts', json_encode($_SESSION['cartProducts']), time() + 3600 * 24 * 30, '/');
		$products = self::get(true);
		echo json_encode([
			'success' => true,
			'total' => array_sum(array_map(function ($product) {
				return $product->countInCart * $product->price;
			}, $products)),
			'count' => count($products)
		]);
	}

	public static function get($products = false): array
	{
		$cartProducts = $_SESSION['cartProducts'] ?? [];
		if ($products) {
			foreach ($cartProducts as $id => $count) {
				$product = (new \App\Models\Product())->getOneObject(['id' => $id]);
				$product->currency = (new Currency())->getOneObject(['id' => $product->currency_id]);
				$product->countInCart = $count;
				$product->sum = $product->price * $count;
				$cartProducts[$id] = $product;
			}
			return $cartProducts;
		} else {
			return array_keys($_SESSION['cartProducts'] ?? []);
		}
	}
}