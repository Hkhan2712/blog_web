<?php 
    global $mediaFiles;
    array_push($mediaFiles['css'], RootREL . 'media/css/post.css')
?>
<?php include_once "views/layouts/user/header.php" ?>

<section class="container py-5">
    <h1 class="py-5 d-flex justify-content-center">Articles</h1>
    <div class="row g-4">
        <?php foreach ($listPosts as $post): 
            $tags = PostTagModel::getTagsByPostId($post['id']);           
        ?>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card post-card h-100 shadow-sm rounded overflow-hidden">
                <?php
                    $imagePath = "media/uploads/posts/cards/" . $post['image_url'];
                    $imageUrl = file_exists($imagePath) ? RootREL . $imagePath : RootREL . "media/uploads/posts/cards/default.png";
                ?>
                <img src="<?= $imageUrl ?>" class="card-img-top" alt="<?= htmlspecialchars($post['title']) ?>" style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">

                    <div class="d-flex justify-content-between align-items-center mb-2 small text-muted">
                    <span><?= $post['author'] ?> · <?= date("M d, Y", strtotime($post['created_at'])) ?></span>
                    <span>
                        <?php 
                            $isLoggedIn = isset($_SESSION['user']['id']) && !empty($_SESSION['user']['id']);
                            if (!$isLoggedIn) {
                                $isLiked = false;
                            } else {
                                $isLiked = LikeRepository::checkExist(
                                    (int)$_SESSION['user']['id'], 
                                    (int)$post['id'], 
                                    'post'
                                );
                            }
                        ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hand-thumbs-up-fill <?= $isLiked ? 'liked' : ''?>" viewBox="0 0 16 16">
                            <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a10 10 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733q.086.18.138.363c.077.27.113.567.113.856s-.036.586-.113.856c-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.2 3.2 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.8 4.8 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
                        </svg>
                        <?= (int)$post['like_quantity'] ?>
                        &nbsp;
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chat-left" viewBox="0 0 16 16">
                            <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                        </svg>
                        <?= (int)$post['comment_quantity'] ?>
                    </span>
                    </div>

                    <div class="mb-2">
                        <?php foreach (array_slice($tags, 0, 3) as $tag): ?>
                            <span class="badge bg-secondary me-1"><?= htmlspecialchars($tag['name']) ?></span>
                        <?php endforeach; ?>
                    </div>
                    <h5 class="card-title"><?= htmlspecialchars($post['title']) ?></h5>
                    <p class="card-text mb-auto"><?= htmlspecialchars(mb_strimwidth(strip_tags($post['content']), 0, 100, '...')) ?></p>
                    <a href="<?= AppUtil::url(['ctl' => 'post', 'act' => 'view', 'params' => [$post['id']]]) ?>" class="btn w-100 mt-2 rounded-pill fw-semibold z-3">Read More</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <div class="pt-4">
        <nav aria-label="Posts navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item <?= ($currentPage <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= ($currentPage <= 1) ? '#' : '?page=' . ($currentPage - 1) ?>" aria-label="Previous">&laquo;</a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
                <?php endfor; ?>
                <li class="page-item <?= ($currentPage >= $totalPages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="<?= ($currentPage >= $totalPages) ? '#' : '?page=' . ($currentPage + 1) ?>" aria-label="Next">&raquo;</a>
                </li>
            </ul>
        </nav>
    </div>
</section>

<?php include_once "views/layouts/user/footer.php" ?>