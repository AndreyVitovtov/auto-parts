<style>
    .card {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f8f9fa;
        font-size: 18px;
        font-weight: bold;
        text-align: center;
        cursor: pointer;
        transition: 0.3s;
    }

    .card:hover {
        background-color: #e2e6ea;
    }

    .h2 {
        margin-top: 20px;
    }

    .path {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        font-size: 14px;
    }

    .path a {
        margin: 0 5px;
        font-weight: bold;
    }
</style>

<div class="container mt-4">
    <nav class="path">
		<?= (!empty($categoryPath) ? '<a href="/"><i class="icon-home"></i></a> <i class="icon-right"></i> ' : '') ?>
		<?= implode(' <i class="icon-right"></i> ', array_map(function ($category) {
			return "<a href='/category/" . $category['slug'] . "'>" . htmlspecialchars($category['title']) . "</a>";
		}, $categoryPath ?? [])) ?>
    </nav>

    <h2 class="text-center mb-4"><?= $categoryTitle ?? __('catalog') ?></h2>

	<?php if (!empty($categories)): ?>
        <div class="row g-3">
			<?php foreach ($categories as $category): ?>
                <a href="/category/<?= $category['slug'] ?>" class="col-6 col-md-4 col-lg-3">
                    <div class="card"><?= nl2br($category['title']) ?></div>
                </a>
			<?php endforeach; ?>
        </div>
	<?php endif; ?>

	<?php if (!empty($products)): ?>
        <div class="row g-3">
			<?php foreach ($products as $product): ?>
                <a href="/product/<?= $product['slug'] ?>" class="col-6 col-md-4 col-lg-3">
                    <div class="card"><?= nl2br($product['title']) ?></div>
                </a>
			<?php endforeach; ?>
        </div>
	<?php endif; ?>
</div>