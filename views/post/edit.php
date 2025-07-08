<?php 
    global $mediaFiles;
    array_push($mediaFiles['css'], RootREL . 'media/css/ckeditor.css');
    array_push($mediaFiles['js'], RootREL . 'media/js/ckeditor.js'); // File chứa CKEditor custom + editorConfig
?>
<?php include_once "views/layouts/user/header.php"; ?>

<div class="container py-5">
    <h2 class="mb-4">Edit Post</h2>

    <form action="<?= AppUtil::url(['ctl' => 'post', 'act' => 'edit', 'params' => [$record['id']]]) ?>" method="POST" enctype="multipart/form-data" id="post-form">
        <!-- Title -->
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input 
                type="text" 
                class="form-control" 
                id="title" 
                name="title" 
                value="<?= htmlspecialchars($record['title']) ?>" 
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
                    <input type="radio" class="btn-check" name="status" id="status-<?= $value ?>" value="<?= $value ?>" <?= ($record['status'] === $value) ? 'checked' : '' ?>>
                    <label class="btn btn-outline-success" for="status-<?= $value ?>"><?= $label ?></label>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Categories -->
        <?php 
        $selectedCategories = array_column(PostCategoryModel::getInstance()->getCategoriesByPostId($record['id']), 'id');
        include "views/components/posts/categoryForm.php";
        ?>

        <!-- Tags -->
        <?php 
        $selectedTags = PostTagModel::getInstance()->getTagsByPostId($record['id']);
        include "views/components/posts/tagForm.php"; 
        ?>

        <!-- Current Image -->
        <?php if (!empty($record['image_url'])): ?>
            <div class="mb-3">
                <label class="form-label">Current Image</label><br>
                <img 
                    src="<?= RootREL . 'media/uploads/posts/cards/' . htmlspecialchars($record['image_url']) ?>" 
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

        <!-- Content (CKEditor) -->
        <div class="mb-3">
            <label for="editor" class="form-label">Content</label>
            <!-- Hidden textarea để submit -->
            <textarea id="content" name="content" style="display:none;"></textarea>

            <!-- CKEditor UI -->
            <div class="editor-container editor-container_classic-editor editor-container_include-outline" id="editor-container">
                <div class="editor-container__editor-wrapper">
                    <div class="editor-container__sidebar" id="editor-outline"></div>
                    <div class="editor-container__editor">
                        <div id="editor"><?= $record['content']?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-3">
            <a href="<?= AppUtil::url(['ctl' => 'post', 'act' => 'view', 'params' => [$record['id']]]) ?>" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', async () => {
        const editorEl = document.querySelector('#editor');
        const textarea = document.querySelector('#content');

        try {
            const editor = await ClassicEditor.create(editorEl, editorConfig);

            // Gắn dữ liệu khi submit
            document.querySelector('#post-form').addEventListener('submit', function (e) {
                textarea.value = editor.getData();
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
