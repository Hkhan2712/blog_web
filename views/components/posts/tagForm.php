<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>

<div class="my-4">
    <?php $tags = TagModel::getInstance()->getRecords('*');?>
    <label for="tags" class="form-label">Tags</label>
    <input id="tags" name="tags" placeholder="Add tags..." autofocus>
</div>

<script>
var input = document.querySelector('input[name=tags]');
var existingTags = [<?php foreach($tags as $tag) echo '"' . htmlspecialchars($tag['name']) . '",'; ?>];

var tagify = new Tagify(input, {
    whitelist: existingTags,
    dropdown: {
        enabled: 0
    }
});

// Set selected tags if available (edit page)
<?php if (isset($selectedTags)): ?>
tagify.addTags(<?= json_encode(array_column($selectedTags, 'name')) ?>);
<?php endif; ?>
</script>

