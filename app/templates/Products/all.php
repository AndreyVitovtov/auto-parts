<table class="table table-striped table-hover table-responsive">
    <thead>
    <tr>
        <th><?= __('title') ?></th>
        <th><?= __('description') ?></th>
        <th><?= __('category') ?></th>
        <th><?= __('price') ?></th>
        <th><?= __('actions') ?></th>
    </tr>
    </thead>
    <tbody>
	<?php foreach ($products as $product): ?>
        <tr>
            <td><?= $product['title'] ?></td>
            <td><?= $product['description'] ?></td>
            <td><?= $categories[$product['category_id']]['path'] ?></td>
            <td><?= $product['price'] ?> <?= $product['currency'] ?></td>
            <td class="table-actions text-right">
                <a href="/admin/products/edit/<?= $product['id'] ?>" class="btn">
                    <i class="icon-edit"></i>
                    <span class="desk"><?= __('edit') ?></span>
                </a>
                <button form="delete-product-<?= $product['id'] ?>" class="btn">
                    <i class="icon-trash"></i>
                    <span class="desk"><?= __('delete') ?></span>
                </button>
                <form action="/admin/products/delete" method="POST"
                      class="form-confirm"
                      id="delete-product-<?= $product['id'] ?>"
                      data-title="<?= __('deletion confirmation') ?>"
                      data-body="<?= __('are you sure you want to remove the product') ?>"
                      data-id="delete-product-<?= $product['id'] ?>"
                >
                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                </form>
            </td>
        </tr>
	<?php endforeach; ?>
    </tbody>
</table>