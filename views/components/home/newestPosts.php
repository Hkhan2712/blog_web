<ul class="col-5 intro-list d-flex flex-column">
    <!-- posts newest -->
    <?php foreach ($this->newestPosts as $post): 
        $tags = [];
        if (isset($post['tags']) && $post['tags']) {
            $tags = array_map('trim', explode(',', $post['tags']));
        }?>
        <li class="post-item row d-flex align-items-stretch" style="min-height: 150px;">
            <img src="<?=RootREL."media/uploads/posts/".$post['image_url']?>" alt="" class="post-image col-4 p-0">
            <div class="post-content col-8 p-0">
                <p class="detail">
                    <?=$post['author_name']?> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dot" viewBox="0 0 16 16">
                        <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
                    </svg>
                    <?=date("F d Y", strtotime($post['created_at']))?>
                </p>
                <a href="<?= AppUtil::url(['ctl' => 'post', 'act' => 'view', 'params' => [$post['id']]])?>" class="h4"><?=$post['title']?></a>
                <div class="d-flex gap-2">
                    <?php foreach ($tags as $tag): ?>
                        <span class="tag"><?= htmlspecialchars($tag) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
        </li>
    <?php endforeach; ?>
</ul>