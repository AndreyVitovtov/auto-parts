<form action="/admin/products/editSave" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?= $product->id ?>">
    <div class="mb-3">
        <label for="title" class="form-label">* <?= __('title') ?>:</label>
        <input type="text" class="form-control" id="title" name="title" value="<?= $product->title ?>" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">* <?= __('description') ?>:</label>
        <textarea name="description" id="description" class="form-control"
                  required><?= $product->description ?></textarea>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label"><?= __('image') ?>:</label>
        <input type="file" class="form-control" id="image" name="image">
    </div>
    <div class="mb-3">
        <label for="category" class="form-label"><?= __('category') ?>:</label>
        <select name="category" id="category" class="form-select">
			<?php foreach ($categories as $category): ?>
                <option value="<?= $category['last_id'] ?>" <?= ($category['last_id'] == $product->category_id ? 'selected' : '') ?>>
					<?= $category['path'] ?>
                </option>
			<?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">* <?= __('price') ?>:</label>
        <input type="text" name="price" value="<?= $product->price ?>" id="price" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="currency" class="form-label"><?= __('currency') ?>:</label>
        <select name="currency" id="currency" class="form-select">
			<?php foreach ($currencies as $currency): ?>
                <option value="<?= $currency->id ?>" <?= ($currency->id == $product->currency_id ? 'selected' : '') ?>>
					<?= $currency->code ?>
                </option>
			<?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="count" class="form-label">* <?= __('count') ?></label>
        <input type="number" name="count" value="<?= $product->count ?>" id="count" class="form-control" required>
    </div>
    <div class="mb-3">
        <input type="submit" value="<?= __('save') ?>" class="btn">
    </div>
</form>