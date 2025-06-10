<?php include_once "views/layouts/user/header.php"?>
<section class="container">
    <div class="row row-cols-1 row-cols-lg-2 g-3 py-5">
        <?php foreach ($this->listPosts as $post):
            $tags = [];
            if (isset($post['tags']) && $post['tags']) {
                $tags = array_map('trim', explode(',', $post['tags']));
            };
        ?>
            <div class="col">
                <div class="post-item d-flex flex-column flex-md-row h-100 p-3 border rounded shadow-sm">
                    <div class="post-thumb me-md-3 mb-3 mb-md-0" style="flex-shrink:0; width: 200px;">
                        <img src="<?=RootREL."media/uploads/posts/".$post['image_url']?>" alt="" class="img-fluid rounded">
                    </div>
                    <div class="post-content">
                        <p class="detail">
                            <?=$post['author_name']?> 
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dot" viewBox="0 0 16 16">
                                <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
                            </svg>
                            <?=date("F d Y", strtotime($post['created_at']))?>
                        </p>
                        <div class="tags">
                            <?php foreach ($tags as $tag): ?>
                                <span class="tag me-1"><?= htmlspecialchars($tag) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <a href="<?php echo AppUtil::url(['ctl' => 'post', 'act' => 'view', 'params' => [$post['id']]]) ?>" class="h4 mb-2"><?= htmlspecialchars($post['title']) ?></a>
                        <p class="flex-grow-1"><?= htmlspecialchars($post['excerpt']) ?></p>
                        <div class="mt-auto">
                            <a href="<?php echo AppUtil::url(['ctl' => 'post', 'act' => 'view', 'params' => [$post['id']]]) ?>" class="btn btn-sm">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<div class="clearfix">
        <nav aria-label="Posts navigation" class = "pt-2">
            <ul class="d-flex justify-content-center pagination">
                <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only"></span>
                </a>
                </li>
                <li class="page-item"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only"></span>
                </a>
                </li>
            </ul>
        </nav>
    </div>
</section>
<?php include_once "views/layouts/user/footer.php" ?>