<?php use App\Utility\Request; ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?? '' ?></title>
    <link rel="stylesheet" href="<?= assets('css/bootstrap.min.css') ?> ">
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
    <nav class="navbar navbar-expand-lg navbar-light container d-flex justify-content-between">
        <!-- Логотип -->
        <a class="navbar-brand" href="/"><?= LOGO ?></a>

        <!-- Кнопка для мобильного меню -->
        <button class="navbar-toggler ms-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Меню -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <!-- Поиск на десктопе -->
            <div class="d-none d-lg-flex justify-content-center flex-grow-1 mx-3">
                <form class="d-flex w-50" role="search">
                    <input class="form-control me-2" type="search" placeholder="Поиск..." aria-label="Search">
                    <button class="btn btn-outline-secondary" type="submit">Найти</button>
                </form>
            </div>
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="/"><?= __('catalog') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="/about"><?= __('about') ?></a></li>
                <li class="nav-item"><a class="nav-link" href="/contacts"><?= __('contacts') ?></a></li>

                <!-- Поиск для мобильных (в выпадающем меню) -->
                <li class="nav-item d-lg-none mt-2">
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Поиск..." aria-label="Search">
                        <button class="btn btn-outline-secondary" type="submit">Найти</button>
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
                <h5>Контакты</h5>
                <ul class="list-unstyled">
                    <li><a href="mailto:info@shop.com" class="text-white">info@shop.com</a></li>
                    <li><a href="tel:+123456789" class="text-white">+1 234 567 89</a></li>
                    <li><a href="#" class="text-white">Адрес магазина</a></li>
                </ul>
            </div>

            <!-- Колонка 2: Быстрые ссылки -->
            <div class="col-md-4 mb-3">
                <h5>Быстрые ссылки</h5>
                <ul class="list-unstyled">
                    <li><a href="/" class="text-white">Главная</a></li>
                    <li><a href="/catalog" class="text-white">Каталог</a></li>
                    <li><a href="/about" class="text-white">О нас</a></li>
                    <li><a href="/contacts" class="text-white">Контакты</a></li>
                </ul>
            </div>

            <!-- Колонка 3: Социальные сети -->
            <div class="col-md-4 mb-3">
                <h5>Следите за нами</h5>
                <ul class="list-unstyled d-flex">
                    <li><a href="#" class="text-white me-3"><i class="fab fa-facebook"></i></a></li>
                    <li><a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a></li>
                    <li><a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a></li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col text-center">
                <p class="mb-0">&copy; 2025 Мой Магазин. Все права защищены.</p>
            </div>
        </div>
    </div>
</footer>

</body>
</html>