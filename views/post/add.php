<?php include_once "views/layouts/user/header.php" ?>

<div class="container mt-5">
    <h2>Add new post</h2>
    
    
    <form action="<?= AppUtil::url(['ctl' => 'post', 'act' => 'add'])?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Cover Image</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary" name="btn_submit">Add</button>
        <a href="<?= AppUtil::url(['ctl'=>'post'])?>" class="btn btn-secondary">cancel</a>
    </form>
</div>

<?php include_once "views/layouts/user/footer.php" ?>
