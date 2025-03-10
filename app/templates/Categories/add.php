<form action="/admin/categories/addSave" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="title" class="form-label">* <?= __('title') ?>:</label>
        <input type="text" name="title" class="form-control" id="title" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">* <?= __('description') ?>:</label>
        <textarea name="description" id="description" class="form-control" required></textarea>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">* <?= __('image') ?>:</label>
        <input type="file" name="image" class="form-control" id="image" required>
    </div>
    <div class="mb-3">
        <label for="parent" class="form-label"><?= __('parent category') ?>:</label>
        <select name="parent" id="parent" class="form-select">
            <option value=""><?= __('no') ?></option>
            <?php displayCategories($categoryTree); ?>
        </select>
    </div>
    <div class="mb-3">
        <input type="submit" value="<?= __('add') ?>" class="btn">
    </div>
</form>

<?php
function displayCategories($categories, $level = 0): void
{
	foreach ($categories as $category) {
		$indent = str_repeat('&nbsp;', $level * 4);

		if (!empty($category['children'])) {
			echo "<optgroup label='" . htmlspecialchars($category['title']) . "'>";
		}

		echo "<option value='" . $category['id'] . "'>" . $indent . htmlspecialchars($category['title']) . "</option>";

		if (!empty($category['children'])) {
			displayCategories($category['children'], $level + 1);
			echo "</optgroup>";
		}
	}
}


?>