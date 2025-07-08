<?php 
    global $mediaFiles;
    array_push($mediaFiles['css'], RootREL . 'media/css/ckeditor.css');
    array_push($mediaFiles['js'], RootREL . 'media/js/ckeditor.js'); 
?>
<?php include_once "views/layouts/user/header.php"; ?>

<div class="container py-5">
    <h2 class="mb-4">Add New Post</h2>

    <form action="<?= AppUtil::url(['ctl' => 'post', 'act' => 'add']) ?>" method="POST" enctype="multipart/form-data" id="post-form">
        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <!-- Status -->
        <div class="mb-3">
            <label class="form-label">Status</label><br>
            <div class="btn-group" role="group">
                <?php 
                $statuses = ['draft' => 'Draft', 'published' => 'Published', 'pending' => 'Pending', 'archived' => 'Archived'];
                foreach ($statuses as $value => $label): ?>
                    <input 
                        type="radio" 
                        class="btn-check" 
                        name="status" 
                        id="status-<?= $value ?>" 
                        value="<?= $value ?>" 
                        <?= ($value === 'draft') ? 'checked' : '' ?> 
                    >
                    <label class="btn btn-outline-success" for="status-<?= $value ?>"><?= $label ?></label>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- Category -->
        <?php include_once "views/components/posts/categoryForm.php"; ?>

        <!-- Tags -->
        <?php include_once "views/components/posts/tagForm.php"; ?>

        <!-- Cover Image -->
        <div class="mb-3">
            <label for="image" class="form-label">Cover Image</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>

        <!-- Content -->
        <div class="mb-3">
            <label for="editor" class="form-label">Content</label>
            <!-- Hidden textarea để submit -->
            <textarea id="content" name="content" style="display:none;"></textarea>

            <!-- CKEditor UI -->
            <div class="editor-container editor-container_classic-editor editor-container_include-outline" id="editor-container">
                <div class="editor-container__editor-wrapper">
                    <div class="editor-container__sidebar" id="editor-outline"></div>
                    <div class="editor-container__editor">
                        <div id="editor"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-3">
            <button type="submit" class="btn btn-primary" name="btn_submit">Publish</button>
            <a href="<?= AppUtil::url(['ctl' => 'post']) ?>" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const editorEl = document.querySelector('#editor');
        const textarea = document.querySelector('#content');

        try {
            const editor = await ClassicEditor.create(editorEl, editorConfig); // editorConfig phải có trong ckeditor.js

            // Khi submit, copy nội dung vào textarea để backend nhận được
            document.querySelector('#post-form').addEventListener('submit', function (e) {
                textarea.value = editor.getData();

                // Ngăn submit nếu không có nội dung
                if (textarea.value.trim() === '') {
                    alert('Please enter content!');
                    e.preventDefault();
                }
            });
        } catch (err) {
            console.error('CKEditor init error:', err);
        }
    });
</script>

<?php include_once "views/layouts/user/footer.php"; ?>
