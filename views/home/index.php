<?php include_once "views/layouts/user/header.php" ?>
<section class="container pt-120">
    <h1>Uncover fresh perspectives, ideas, and knowledge <br>through the power of blogs.</h1>
    <p>Redfy is an open platform where readers find dynamic thinking, and where expert and undiscovered voices can share their writing on any topic</p>
    <a href="<?= AppUtil::url(['ctl' => 'post'])?>" class="btn btn-primary">Start Reading 
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0M4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5z"/>
        </svg>
    </a>
</section>
<section class="container">
    <div class="row row-cols-2 align-items-stretch">
        <!-- outstanding post -->
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
    </div>
</section>
<section class="container pt-120">
    <h2 class="pb-3">Featured Categories</h2>   
    <div class = "row row-cols-1 row-cols-lg-3">
        <div class="col py-2">
            <div class="category-card">
                <img src="<?=RootREL."media/uploads/categories/animals.jpg"?>" alt="">
                <a href="">Animal</a>
            </div>
            
        </div>
        <div class="col py-2">
            <div class="category-card">
                <img src="<?=RootREL."media/uploads/categories/finance.jpg"?>" alt="">
                <a href="">Finance</a>
            </div>
        </div>
        <div class="col py-2">
            <div class="category-card">
                <img src="<?=RootREL."media/uploads/categories/technology.jpg"?>" alt="">
                <a href="">Technology</a>
            </div>
            
        </div>
    </div>
</section>
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
                <div class="post-item d-flex" style="min-height: 284.79px;">
                    <div class="post-thumb">
                        <img src="<?=RootREL."media/uploads/posts/".$post['image_url']?>" alt="">
                    </div>
                    <div class="post-content">
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
        <nav aria-label="Posts navigation" class = "pt-2">
            <ul class="pagination">
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
<section class="bg-dark" style="margin-top: 120px;">
    <div class="container text-white py-5">
        <div class="row row-cols-2">
            <div class="col">
                <h3>Our Story</h3>
                <h1>A little bit about MBlog</h1>
                <p>MBlog was born from a simple yet powerful idea: to create a vibrant space where compelling stories, insightful analyses, and practical knowledge could be shared and discovered. In a world brimming with information, we saw the need for a platform that not only hosts diverse voices but also connects readers with content that genuinely enriches their lives.</p>
                <a href="" class="btn btn-primary">READ MORE</a>
            </div>
            <div class="col">
                <img src="<?=RootREL."media/img/mission.jpg"?>" alt="" style="width: 100%;
                    height: 100%;
                    object-fit: cover;
                    border-radius: 10px;">
            </div>
        </div>
    </div>
</section>

<?php include_once "views/layouts/user/footer.php" ?>