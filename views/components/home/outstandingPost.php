<div class="post-intro col-7">
    <?php $post = PostRepository::getOutstandingPost(); ?>
    <div class="image-container">
        <img src="<?= RootREL."media/uploads/posts/".$post['image_url']?>" alt="">
        <div class="text-overlay w-100">
            <div class="d-flex gap-1 align-items-center">
                <p><?= $post['user']['username']?></p> 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dot" viewBox="0 0 16 16">
                <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
                </svg>
                <?=date("F d Y", strtotime($post['created_at']))?>
            </div>
            <a href="<?= AppUtil::url(['ctl' => 'post', 'act' => 'view', 'params' => [$post['id']]])?>" class="h3"><?= $post['title']?></a>
            <p>
                <?= htmlspecialchars(mb_strimwidth(strip_tags($post['content']), 0, 80, '...')) ?>
            </p>
        </div>
    </div>
</div>