<?php use App\Controllers\Cart;
use App\Utility\Request; ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?? '' ?> | <?= TITLE ?></title>
    <link rel="stylesheet" href="<?= assets('css/bootstrap.min.css') ?> ">
    <link rel="stylesheet" href="<?= assets('css/bootstrap-icons.css') ?> ">
    <link rel="stylesheet" href="<?= assets('css/all.min.css') ?> ">
    <link rel="stylesheet" href="<?= assets('css/fontello/fontello.css') ?> ">
    <link rel="stylesheet" href="<?= assets('css/main.css') ?>">
    <link rel="stylesheet" href="<?= assets('css/media.css') ?>">
    <link rel="icon" type="image/x-icon" href="<?= assets('images/favicon.png') ?>">
    <script src="<?= assets('js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= assets('js/jquery-3.7.1.min.js') ?>"></script>
<!--    <script src="--><?php //= assets('js/main.js') ?><!--"></script>-->
	<?php
	if (isset($assets['css'])) {
		echo implode("\n", array_map(function ($v) {
			return '<link rel="stylesheet" href="' . assets('css/' . $v) . '">';
		}, (is_array($assets['css']) ? $assets['css'] : [$assets['css']])));
	}

	if (isset($assets['js'])) {
		echo implode("\n", array_map(function ($v) {
			return '<script src="' . assets('js/' . $v) . '"></script>';
		}, (is_array($assets['js']) ? $assets['js'] : [$assets['js']])));
	}
	?>
</head>
<body>
<header class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light container d-flex justify-content-between align-items-center">
        <!-- Логотип -->
        <a class="navbar-brand" href="/"><?= LOGO ?></a>

        <div class="d-flex align-items-center">
            <!-- Корзина (в мобильной версии рядом с меню) -->
            <a class="nav-link position-relative d-lg-none me-3" href="/cart">
                <i class="bi bi-cart3 fs-4"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart">
                    <?= count(Cart::get()) ?> <!-- Здесь можно вставить динамическое количество товаров -->
                </span>
            </a>

            <!-- Кнопка для мобильного меню -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

        <!-- Меню -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <!-- Поиск на десктопе -->
            <div class="d-none d-lg-flex justify-content-center flex-grow-1 mx-3">
                <form class="d-flex w-50" role="search">
                    <input class="form-control me-2" type="search" placeholder="<?= __('search') ?>..." aria-label="Search">
                    <button class="btn btn-outline-secondary" type="submit"><?= __('search') ?></button>
                </form>
            </div>
            <ul class="navbar-nav align-items-center">
                <li class="nav-item"><a class="nav-link" href="/"><?= __('catalog') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="/about"><?= __('about') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="/contacts"><?= __('contacts') ?></a></li>

                <!-- Корзина (только на десктопе) -->
                <li class="nav-item ms-3 d-none d-lg-block">
                    <a class="nav-link position-relative" href="/cart">
                        <i class="bi bi-cart3 fs-4"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart">
                            <?= count(Cart::get()) ?>
                        </span>
                    </a>
                </li>

                <!-- Поиск для мобильных (в выпадающем меню) -->
                <li class="nav-item d-lg-none mt-2">
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="<?= __('search') ?>..." aria-label="Search">
                        <button class="btn btn-outline-secondary" type="submit"><?= __('search') ?></button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
</header>

<main>
    <div class="main-content">
		<?php if (!empty($template)) require_once $template . '.php'; ?>
    </div>
</main>
<footer class="bg-dark text-white py-4">
    <div class="container">
        <div class="row">
            <!-- Колонка 1: Контакты -->
            <div class="col-md-4 mb-3">
                <h5><?= __('contacts') ?></h5>
                <ul class="list-unstyled">
                    <li><a href="mailto:info@shop.com" class="text-white">info@shop.com</a></li>
                    <li><a href="tel:+123456789" class="text-white">+38(050) 123 45 67</a></li>
                    <li><a href="#" class="text-white"><?= __('address') ?></a></li>
                </ul>
            </div>

            <!-- Колонка 2: Быстрые ссылки -->
            <div class="col-md-4 mb-3">
                <h5><?= __('fast link') ?></h5>
                <ul class="list-unstyled">
                    <li><a href="/" class="text-white"><?= __('catalog') ?></a></li>
                    <li><a href="/about" class="text-white"><?= __('about') ?></a></li>
                    <li><a href="/contacts" class="text-white"><?= __('contacts') ?></a></li>
                </ul>
            </div>

            <!-- Колонка 3: Социальные сети -->
            <div class="col-md-4 mb-3">
                <h5><?= __('socials') ?></h5>
                <ul class="list-unstyled d-flex">
                    <li><a href="#" class="text-white me-3"><i class="fab fa-facebook"></i></a></li>
                    <li><a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a></li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col text-center">
                <p class="mb-0">&copy; <?= YEAR ?> <?= TITLE ?> <?= COPYRIGHT ?></p>
            </div>
        </div>
    </div>
</footer>

</body>
</html>