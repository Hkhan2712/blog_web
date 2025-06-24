<div class="mb-3">
    <label class="form-label">Categories</label>
    <div class="row">
        <?php foreach ($categories as $category): ?>
            <div class="col-6 col-md-4">
                <div class="form-check">
                    <input class="form-check-input" 
                           type="checkbox" 
                           name="categories[]" 
                           value="<?= $category['id'] ?>" 
                           id="category-<?= $category['id'] ?>"
                           <?= (isset($selectedCategories) && in_array($category['id'], $selectedCategories)) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="category-<?= $category['id'] ?>">
                        <?= htmlspecialchars($category['name']) ?>
                    </label>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
