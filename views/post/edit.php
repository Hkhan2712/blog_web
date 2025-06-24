<?php include_once "views/layouts/user/header.php"; ?>

<div class="container py-5">
    <h2 class="mb-4">Edit Post</h2>

    <form action="<?= AppUtil::url(['ctl' => 'post', 'act' => 'edit', 'params' => [$this->record['id']]]) ?>" method="POST" enctype="multipart/form-data">
        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input 
                type="text" 
                class="form-control" 
                id="title" 
                name="title" 
                value="<?= htmlspecialchars($this->record['title']) ?>" 
                required
            >
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label class="form-label">Status</label><br>
            <div class="btn-group" role="group">
                <?php 
                $statuses = ['draft' => 'Draft', 'published' => 'Published', 'pending' => 'Pending', 'archived' => 'Archived'];
                foreach ($statuses as $value => $label): ?>
                    <input type="radio" class="btn-check" name="status" id="status-<?= $value ?>" value="<?= $value ?>" <?= ($this->record['status'] === $value) ? 'checked' : '' ?>>
                    <label class="btn btn-outline-success" for="status-<?= $value ?>"><?= $label ?></label>
                <?php endforeach; ?>
            </div>
        </div>


        <!-- Categories -->
        <?php 
        $selectedCategories = array_column(PostCategoryModel::getInstance()->getCategoriesByPostId($this->record['id']), 'id');
        include "views/components/posts/categoryForm.php";
        ?>

        <!-- Tags -->
        <?php 
        $selectedTags = PostTagModel::getInstance()->getTagsByPostId($this->record['id']);
        include "views/components/posts/tagForm.php"; 
        ?>
        
        <!-- Current Image -->
        <?php if (!empty($this->record['image_url'])): ?>
            <div class="mb-3">
                <label class="form-label">Current Image</label><br>
                <img 
                    src="<?= RootREL . 'media/uploads/posts/' . htmlspecialchars($this->record['image_url']) ?>" 
                    alt="" 
                    class="img-thumbnail" 
                    style="max-height: 200px;"
                >
            </div>
        <?php endif; ?>

        <!-- Upload New Image -->
        <div class="mb-3">
            <label for="image" class="form-label">Change Image (optional)</label>
            <input 
                type="file" 
                class="form-control" 
                id="image" 
                name="image" 
                accept="image/*"
            >
        </div>

        <!-- Content -->
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea 
                class="form-control" 
                id="content" 
                name="content" 
                rows="10"
            ><?= htmlspecialchars($this->record['content']) ?></textarea>
        </div>

        <div class="d-flex gap-3">
            <a href="<?= AppUtil::url(['ctl' => 'post', 'act' => 'view', 'params' => [$this->record['id']]]) ?>" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Changes</button>
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
