<div class="post-intro col-7">
    <div class="image-container">
        <img src="<?= RootREL."media/uploads/posts/".$this->outstanding['image_url']?>" alt="">
        <div class="text-overlay w-100">
            <div class="d-flex gap-1 align-items-center">
                <p><?= $this->outstanding['author_name']?></p> 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dot" viewBox="0 0 16 16">
                <path d="M8 9.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3"/>
                </svg>
                <p><?= $this->outstanding['created_at']?></p>
            </div>
            <a href="<?= AppUtil::url(['ctl' => 'post', 'act' => 'view', 'params' => [$this->outstanding['id']]])?>" class="h3"><?= $this->outstanding['title']?></a>
            <p>
                <?= $this->outstanding['excerpt']?>
            </p>
        </div>
    </div>
</div>