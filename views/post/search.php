<?php include_once "views/layouts/user/header.php" ?>

<div class="container py-5">
    <h2>Search Results for "<?= htmlspecialchars($keyword) ?>"</h2>

    <?php if (empty($listPosts)): ?>
        <p>No posts found.</p>
    <?php else: ?>
        <div class="list-group">
            <?php foreach ($listPosts as $post): ?>
                <a href="<?= AppUtil::url(['ctl' => 'post', 'act' => 'view', 'params' => [$post['id']]]) ?>" class="list-group-item list-group-item-action">
                    <h5><?= htmlspecialchars($post['title']) ?></h5>
                    <p class="text-muted small"><?= date("F d, Y", strtotime($post['created_at'])) ?></p>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if ($totalPages > 1): ?>
            <nav class="mt-4">
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                            <a class="page-link" href="<?= AppUtil::url(['ctl' => 'post', 'act' => 'search']) . "&keyword=" . urlencode($this->keyword) . "&page=$i" ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php include_once "views/layouts/user/footer.php" ?>
