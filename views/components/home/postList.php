<section class="container">
    <h2 class="pb-3">Articles</h2>
    <div class="d-flex flex-column align-items-center">
        <div class="d-flex flex-column gap-2">
            <!-- list of posts -->
            <?php foreach ($this->listPosts as $post):
                $tags = [];
                if (isset($post['tags']) && $post['tags']) {
                    $tags = array_map('trim', explode(',', $post['tags']));
                }
            ?>
                <div class="post-item d-flex" style="max-height: 284.79px;">
                    <div class="post-thumb">
                        <img src="<?=RootREL."media/uploads/posts/".$post['image_url']?>" alt="">
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
                                <span class="tag"><?= htmlspecialchars($tag) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <a href="<?= AppUtil::url(['ctl' => 'post', 'act' => 'view', 'params' => [$post['id']]]) ?>" class="h3"><?= htmlspecialchars($post['title']) ?></a>
                        <p><?= htmlspecialchars($post['excerpt']) ?></p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="<?php echo AppUtil::url(['ctl' => 'post', 'act' => 'view', 'params' => [$post['id']]]) ?>" class="btn">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div> 
    </div>
</section>