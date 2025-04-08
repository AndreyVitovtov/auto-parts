<style>
    .card {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 120px;
        border: 1px solid #ddd;
        border-radius: 8px;
        background-color: #f8f9fa;
        font-size: 18px;
        font-weight: bold;
        text-align: center;
        cursor: pointer;
        transition: 0.3s;
        overflow: hidden;
        height: 100%;
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

    .category-card {
        text-decoration: none;
        color: inherit;
    }

    .card-image {
        width: 100%;
        height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        overflow: hidden;
    }

    .no-image {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e9ecef;
        color: #6c757d;
        font-size: 40px;
    }

    .card-body {
        padding: 12px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .card-title {
        font-size: 14px;
        font-weight: bold;
        white-space: normal; /* Разрешаем перенос строк */
        word-wrap: break-word; /* Разрыв длинных слов */
        max-height: 52px; /* Ограничиваем высоту в 3 строки */
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3; /* Ограничиваем количество строк */
        -webkit-box-orient: vertical;
    }

    .product-card {
        text-decoration: none;
        color: inherit;
    }

    .card:hover {
        /*transform: translateY(-5px);*/
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    }

    .no-image {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e9ecef;
        color: #6c757d;
        font-size: 40px;
    }

    .price {
        font-size: 18px;
        font-weight: bold;
        color: #28a745;
    }

    .btn-sm {
        font-size: 14px;
        padding: 5px 10px;
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
        <div class="row g-4">
			<?php foreach ($categories as $category): ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="/category/<?= $category['slug'] ?>" class="category-card">
                        <div class="card shadow-sm border-0">
                            <div class="card-image" style="background-image: url('<?= assets('images/categories/' . $category['image']) ?>');">
                            </div>
                            <div class="card-body text-center">
                                <h6 class="card-title"><?= htmlspecialchars($category['title']) ?></h6>
                            </div>
                        </div>
                    </a>
                </div>
			<?php endforeach; ?>
        </div>
	<?php endif; ?>

	<?php if (!empty($products)): ?>
        <div class="row g-4">
			<?php foreach ($products as $product): ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="/product/<?= $product->slug ?>" class="product-card">
                        <div class="card shadow-sm border-0">
                            <div class="card-image" style="background-image: url('<?= assets('images/products/' . $product->image) ?>');">
                            </div>
                            <div class="card-body text-center">
                                <h6 class="card-title"><?= htmlspecialchars($product->title) ?></h6>
                                <div class="price">
                                    <?= $product->price ?>
                                    <?= $product->currencyCode ?>
                                </div>
                                <?php if(in_array($product->id, $cartProducts ?? [])): ?>
                                    <button class="btn btn-secondary btn-sm mt-2 in-cart"><?= __('in cart') ?></button>
                                <?php else: ?>
                                    <button class="btn btn-primary btn-sm mt-2 add-to-cart" data-id="<?= $product->id ?>"><?= __('buy') ?></button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                </div>
			<?php endforeach; ?>
        </div>
	<?php endif; ?>
</div>