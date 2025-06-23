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
            <textarea class="form-control" id="content" name="content" rows="10" required></textarea>
        </div>

        <div class="d-flex gap-3">
            <button type="submit" class="btn btn-primary" name="btn_submit">Publish</button>
            <a href="<?= AppUtil::url(['ctl' => 'post']) ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<!-- CKEditor 5 CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#content'), {
        toolbar: [
            'heading', '|',
            'bold', 'italic', 'underline', 'link', 'bulletedList', 'numberedList', '|',
            'blockQuote', 'codeBlock', '|',
            'insertTable', 'mediaEmbed', '|',
            'undo', 'redo'
        ],
        mediaEmbed: {
            previewsInData: true
        }
    }).catch(error => console.error(error));
</script>

<?php include_once "views/layouts/user/footer.php"; ?>