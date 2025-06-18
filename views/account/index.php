<?php include_once "views/layouts/user/header.php"; ?>

<div class="container my-4">

    <!-- User Info -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <img src="/media/uploads/users/<?php echo htmlspecialchars($_SESSION['user']['avatar_url']); ?>" 
                     alt="Profile Image" class="rounded-circle border border-2" width="100" height="100">
                <div class="ms-3">
                    <h3 class="mb-0"><?= htmlspecialchars($_SESSION['user']['username']); ?></h3>
                    <small class="text-muted"><?= htmlspecialchars($_SESSION['user']['email']); ?></small>
                </div>
            </div>
            <a href="<?= AppUtil::url(['ctl' => 'account', 'act' => 'edit']) ?>" 
               class="btn btn-outline-primary">
                Edit Profile
            </a>
        </div>
    </div>

    <!-- User's Posts -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Your Blog Posts</h4>
        <a href="<?= AppUtil::url(['ctl' => 'post', 'act' => 'add']) ?>" class="btn btn-primary">+ New Post</a>
    </div>

    <?php if (!empty($this->posts)): ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $stt = 1; foreach ($this->posts as $post): ?>
                        <tr>
                            <td><?= $stt++ ?></td>
                            <td class="fw-medium"><?= htmlspecialchars($post['title']) ?></td>
                            <td>
                                <span class="badge <?= ($post['status'] === 'published') ? 'bg-success' : 'bg-secondary' ?>">
                                    <?= ucfirst(htmlspecialchars($post['status'])) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars(date("M d, Y", strtotime($post['created_at']))) ?></td>
                            <td class="text-end">
                                <a href="<?= AppUtil::url(['ctl' => 'post', 'act' => 'edit', 'id' => $post['id']]) ?>" 
                                   class="btn btn-sm btn-outline-warning me-1">Edit</a>
                                <a href="<?= AppUtil::url(['ctl' => 'post', 'act' => 'del', 'id' => $post['id']]) ?>" 
                                   class="btn btn-sm btn-outline-danger" 
                                   onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">You have not written any posts yet.</div>
    <?php endif; ?>

</div>

<?php include_once "views/layouts/user/footer.php"; ?>