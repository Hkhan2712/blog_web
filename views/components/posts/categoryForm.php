<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<div class="my-4">
    <label for="categories" class="form-label">Categories</label>
    <input id="categories" name="categories" placeholder="Add categories..." autofocus>
</div>
<script>
    const catInput = document.querySelector('input[name=categories]');
    const availableCategories = [
        <?php foreach($categories as $cat) echo '"' . htmlspecialchars($cat['name']) . '",'; ?>
    ];

    const catTagify = new Tagify(catInput, {
        whitelist: availableCategories,
        dropdown: {
            enabled: 1,
            closeOnSelect: false
        }
    });

    <?php if (isset($selectedCategories)): ?>
    // Tìm tên tương ứng với ID đã lưu
    const selectedNames = <?= json_encode(array_map(function($id) use ($categories) {
        foreach ($categories as $cat) {
            if ($cat['id'] == $id) return $cat['name'];
        }
        return null;
    }, $selectedCategories)) ?>.filter(Boolean);

    catTagify.addTags(selectedNames);
    <?php endif; ?>
</script>
