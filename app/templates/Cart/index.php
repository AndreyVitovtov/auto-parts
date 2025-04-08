<style>
    .quantity-control {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .quantity-control button {
        width: 30px;
        height: 30px;
        padding: 0;
        font-size: 18px;
        line-height: 1;
    }

    .quantity-number {
        min-width: 32px;
        text-align: center;
    }
</style>


<div class="container my-5">
	<?php if (empty($products)): ?>

        <div><?= __('empty cart') ?></div>

	<?php else: ?>

        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white">
                <h4 class="mb-0"><?= __('cart') ?></h4>
            </div>
            <div class="card-body">
				<?php
				$total = 0;
				foreach ($products ?? [] as $product):
					$total += $product->sum;
					?>
                    <div class="row align-items-center border-bottom py-3" id="cart-product-<?= $product->id ?>">
                        <div class="col-md-4">
                            <a href="/product/<?= $product->slug ?>"
                               class="fw-bold text-decoration-none text-dark"><?= $product->title ?></a>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="quantity-control justify-content-center">
                                <button class="btn btn-outline-secondary btn-sm change-count-product" data-type="minus"
                                        data-id="<?= $product->id ?>">−
                                </button>
                                <div class="quantity-number"
                                     id="cart-count-product-<?= $product->id ?>"><?= $product->countInCart ?></div>
                                <button class="btn btn-outline-secondary btn-sm change-count-product" data-type="plus"
                                        data-id="<?= $product->id ?>">
                                    +
                                </button>
                            </div>
                        </div>
                        <div class="col-md-2 text-end">
                            <span class="text-success"><?= $product->price ?> <?= $product->currency->code ?></span>
                        </div>
                        <div class="col-md-2 text-end">
                            <button class="btn btn-sm btn-outline-danger delete-from-cart" data-id="<?= $product->id ?>"><?= __('delete') ?></button>
                        </div>
                    </div>
				<?php endforeach; ?>

                <div class="row py-3">
                    <div class="col text-end cart-total">
                        <h5 class="mb-0"><?= __('total') ?>: <span
                                    class="text-primary"><?= $total ?></span> <?= $currency->code ?></h5>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <a href="/order" class="btn btn-success"><?= __('place an order') ?></a>
                </div>

            </div>
        </div>
	<?php endif; ?>
</div>