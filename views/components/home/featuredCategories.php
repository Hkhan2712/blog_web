<section class="container pt-120">
    <h2 class="pb-3">Featured Categories</h2>   
    <div class = "row row-cols-1 row-cols-lg-3">
        <?php foreach ($categories as $category): ?>
            <div class="col py-2">
                <div class="category-card">
                    <img src="<?=RootREL."media/uploads/categories/".$category['img_url']?>" alt="">
                    <a href="<?= AppUtil::url(['ctl'=>'category', 'act' => 'show', 'params' => [$category['id']]])?>"><?= htmlspecialchars($category['name']) ?></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>