<?php
global $menu;
$menu = [
	[
		'title' => __('dashboard'),
		'icon' => 'chart-bar-1',
		'address' => '/admin/',
		'controller' => 'Main'
	], [
		'title' => __('categories'),
		'icon' => 'archive',
		'controller' => 'Categories',
        'forbid' => ['guest'],
		'items' => [
			[
				'title' => __('add'),
				'address' => '/admin/categories/add',
				'method' => 'add'
			], [
				'title' => __('all'),
				'address' => '/admin/categories/all',
				'method' => 'all'
			]
		]
	], [
		'title' => __('products'),
		'icon' => 'barcode',
		'controller' => 'Products',
        'forbid' => ['guest'],
		'items' => [
			[
				'title' => __('add'),
				'address' => '/admin/products/add',
				'method' => 'add'
			], [
				'title' => __('all'),
				'address' => '/admin/products/all',
				'method' => 'all'
			]
		]
	], [
		'title' => __('orders'),
		'icon' => 'folder-open',
		'controller' => 'Orders',
        'forbid' => ['guest'],
		'items' => [
			[
				'title' => __('new'),
				'address' => '/admin/orders/new',
				'method' => 'new'
			], [
				'title' => __('archive'),
				'address' => '/admin/orders/archive',
				'method' => 'archive'
			]
		]
	],[
		'title' => __('administrators'),
		'icon' => 'star',
		'address' => '/admin/administrators',
		'controller' => 'Administrators',
		'assets' => ['superadmin']
	], [
		'title' => __('settings'),
		'icon' => 'cogs',
		'address' => '/admin/settings',
		'controller' => 'Settings',
		'assets' => [],
		'forbid' => ['guest']
	]
];
?>

<div class="logo">
    <a href="/admin/">
		<?= PROJECT_NAME ?>
    </a>
</div>
<div class="menu-items">
	<?= implode('', array_map(function ($i) {
		extract($i);
		return isset($items) ?
			menuRoll($title, $icon, $controller, $items, $access ?? [], $forbid ?? []) :
			menuItem($title, $icon, $address, $controller, $assets ?? [], $forbid ?? []);
	}, $menu)) ?>
</div>