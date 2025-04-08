<table class="table table-striped table-hover table-responsive">
    <thead>
    <tr>
        <th><?= __('title') ?></th>
        <th><?= __('description') ?></th>
	    <th class="text-right"><?= __('actions') ?></th>
    </tr>
    </thead>
    <tbody>
	<?php foreach ($categories as $category): ?>
        <tr>
	        <td><?= $category->title ?></td>
	        <td><?= $category->description ?></td>
	        <td class="table-actions text-right">
		        <a href="/admin/categories/edit/<?= $category->id ?>" class="btn">
			        <i class="icon-edit"></i>
			        <span class="desk"><?= __('edit') ?></span>
		        </a>
		        <button form="delete-category-<?= $category->id ?>" class="btn">
			        <i class="icon-trash"></i>
			        <span class="desk"><?= __('delete') ?></span>
		        </button>
		        <form action="/admin/categories/delete" method="POST"
		              class="form-confirm"
		              id="delete-category-<?= $category->id ?>"
		              data-title="<?= __('deletion confirmation') ?>"
		              data-body="<?= __('are you sure you want to remove the category') ?>"
		              data-id="delete-category-<?= $category->id ?>"
		        >
			        <input type="hidden" name="id" value="<?= $category->id ?>">
		        </form>
	        </td>
        </tr>
	<?php endforeach; ?>
    </tbody>
</table>