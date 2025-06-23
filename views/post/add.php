<?php include_once "views/layouts/user/header.php"; ?>

<div class="container py-5">
    <h2 class="mb-4">Add New Post</h2>

    <form action="<?= AppUtil::url(['ctl' => 'post', 'act' => 'add']) ?>" method="POST" enctype="multipart/form-data">
        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <!-- Tags -->
        <div class="mb-3">
            <label for="tags" class="form-label">Tags (separated by commas)</label>
            <input type="text" class="form-control" id="tags" name="tags" placeholder="e.g. PHP, Programming, Web Development">
        </div>

        <!-- Cover Image -->
        <div class="mb-3">
            <label for="image" class="form-label">Cover Image</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>

        <!-- Content -->
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="10"></textarea>
        </div>

        <div class="d-flex gap-3">
            <button type="submit" class="btn btn-primary" name="btn_submit">Publish</button>
            <a href="<?= AppUtil::url(['ctl' => 'post']) ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<!-- TinyMCE -->
<script src="https://cdn.tiny.cloud/1/bywwhzmxbuun804w7e7tkx0er4yfhcyylwb466fksk4l8m3r/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
	selector: '#content',
	height: 500,
	plugins: 'image media link lists code table',
	toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image media | code',
	automatic_uploads: true,
	images_upload_url: '<?= AppUtil::url(['ctl' => 'post', 'act' => 'uploadTinyMce']) ?>',
	file_picker_types: 'image',
	images_upload_handler: function (blobInfo, success, failure) {
		let formData = new FormData();
		formData.append('file', blobInfo.blob(), blobInfo.filename());
		fetch('<?= AppUtil::url(['ctl' => 'post', 'act' => 'uploadTinyMce']) ?>', {
			method: 'POST',
			body: formData
		})
		.then(response => response.json())
		.then(result => {
			success(result.location);
		})
		.catch(() => failure('Upload failed.'));
	}
});
document.querySelector('form').addEventListener('submit', function(e) {
	const content = tinymce.get('content').getContent({ format: 'text' }).trim();
	if (content === '') {
		alert('Please enter content!');
		e.preventDefault();
	}
});
</script>

<?php include_once "views/layouts/user/footer.php"; ?>
