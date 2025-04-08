<style>
    .path {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        font-size: 14px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        max-width: 100%;
    }

    .path a, .path span {
        margin: 0 5px;
        font-weight: bold;
        flex-shrink: 0;
    }

    .path span {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        display: inline-block;
    }
</style>

<div class="container mt-4">
    <nav class="path mb-3">
		<?= (!empty($categoryPath) ? '<a href="/"><i class="icon-home"></i></a> <i class="icon-right"></i> ' : '') ?>
		<?= implode(' <i class="icon-right"></i> ', array_map(function ($category) {
			return "<a href='/category/" . $category['slug'] . "'>" . htmlspecialchars($category['title']) . "</a>";
		}, $categoryPath ?? [])) ?><span><i class="icon-right"></i> <?= $product->title ?></span>
    </nav>
    <div class="row">
        <div class="col-md-6">
            <img src="<?= assets('images/products/' . $product->image) ?>" class="img-fluid rounded" alt="image">
        </div>
        <div class="col-md-6">
            <h1 class="fw-bold"><?= $product->title ?></h1>
            <p class="text-muted"><?= $product->description ?></p>
            <h3 class="text"><?= $product->price ?> <?= $product->currency ?></h3>
            <?php if(in_array($product->id, $cartProducts ?? [])): ?>
                <button class="btn btn-secondary btn-lg mt-3 in-cart"><?= __('in cart') ?></button>
            <?php else: ?>
                <button class="btn btn-primary btn-lg mt-3 add-to-cart" data-id="<?= $product->id ?>"><?= __('buy') ?></button>
            <?php endif; ?>
        </div>
    </div>
</div>