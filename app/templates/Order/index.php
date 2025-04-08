<div class="container">
    <div class="row">
        <form action="/" method="POST" class="mt-3">
            <div class="mb-3">
                <label for="first-name" class="form-label">* <?= __('first name') ?></label>
                <input type="text" name="first-name" class="form-control" id="first-name" required>
            </div>
            <div class="mb-3">
                <label for="last-name" class="form-label">* <?= __('first name') ?></label>
                <input type="text" name="last-name" class="form-control" id="last-name" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">* <?= __('phone') ?></label>
                <input type="tel" name="phone" id="phone" class="form-control" placeholder="+380(___) ___-__-__"
                       required>
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">* <?= __('city') ?></label>
                <input type="text" name="city" class="form-control city" id="city" list="cities"
                       placeholder="<?= __('start typing') ?>" required>
                <datalist id="cities"></datalist>
            </div>
            <div class="mb-3">
                <label for="warehouse" class="form-label">* <?= __('warehouse') ?></label>
                <input type="text" name="warehouse" class="form-control warehouse" id="warehouse"
                       placeholder="<?= __('start typing') ?>" required>
            </div>
            <div class="mb-3 d-flex justify-content-end mt-3">
                <input type="submit" value="<?= __('send') ?>" class="btn btn-primary">
            </div>
        </form>
    </div>
</div>
