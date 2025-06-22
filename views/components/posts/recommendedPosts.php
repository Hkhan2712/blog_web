<?php if (!empty($recommendedPosts)): ?>
<section class="recommended-posts-section mt-5">
    <h2 class="h4 mb-4">Recommended Posts</h2>
    <div class="row g-3">
        <?php foreach ($recommendedPosts as $post): ?>
            <article class="col-md-4">
                <div class="card h-100 border-0 shadow-sm post-card" style="transition: transform 0.3s, box-shadow 0.3s;">
                    <?php if (!empty($post['image_url'])): ?>
                        <a href="<?= AppUtil::url(['ctl' => 'post', 'act' => 'view', 'params' => [$post['id']]]) ?>" class="d-block ratio ratio-16x9 overflow-hidden">
                            <img 
                                src="<?= RootREL . 'media/uploads/posts/' . htmlspecialchars($post['image_url']) ?>" 
                                alt="<?= htmlspecialchars($post['title']) ?>" 
                                class="object-fit-cover rounded-top img-zoom" 
                                loading="lazy"
                                style="transition: transform 0.4s;"
                            >
                        </a>
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column">
                        <h3 class="h6 mb-2">
                            <a href="<?= AppUtil::url(['ctl' => 'post', 'act' => 'view', 'params' => [$post['id']]]) ?>" class="text-decoration-none post-title-link">
                                <?= htmlspecialchars($post['title']) ?>
                            </a>
                        </h3>
                        <div class="text-muted small mb-2">
                            <time><?= date('d/m/Y', strtotime($post['created_at'])) ?></time> 
                             By <span class="fw-semibold"><?= htmlspecialchars($post['author_name']) ?></span>
                        </div>
                        <p class="card-text text-muted small mb-0 flex-grow-1">
                            <?= htmlspecialchars(mb_strimwidth(strip_tags($post['content']), 0, 80, '...')) ?>
                        </p>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>