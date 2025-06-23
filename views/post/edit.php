<?php include_once "views/layouts/user/header.php"; ?>

<section class="container py-5">
    <h1 class="mb-4">Edit Post</h1>

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

        <!-- Tags -->
        <div class="mb-3">
            <label for="tags" class="form-label">Tags (separated by commas)</label>
            <input 
                type="text" 
                class="form-control" 
                id="tags" 
                name="tags" 
                value="<?= htmlspecialchars($this->record['tags'] ?? '') ?>"
            >
        </div>

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
                required
            ><?= htmlspecialchars($this->record['content']) ?></textarea>
        </div>

        <div class="d-flex justify-content-between">
            <a href="<?= AppUtil::url(['ctl' => 'post', 'act' => 'view', 'params' => [$this->record['id']]]) ?>" class="btn btn-secondary">
                Cancel
            </a>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
    </form>
</section>

<?php include_once "views/layouts/user/footer.php"; ?>
