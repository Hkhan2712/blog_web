<?php
/** @var array $mediaFiles */
global $mediaFiles;
array_push($mediaFiles['css'], RootREL . 'media/css/post.css');
array_push($mediaFiles['js'], RootREL . 'media/js/config.js');
array_push($mediaFiles['js'], RootREL . 'media/js/like.js');
array_push($mediaFiles['js'], RootREL . 'media/js/comment.js');
$data = $this->record;
$isLoggedIn = isset($_SESSION['user']);
// var_dump($data['post']); exit;
?>
<?php include_once "views/layouts/user/header.php" ?>

<section class="container py-5">
    <?php include_once "views/components/posts/postHeader.php" ?>

    <article class="content pt-4 pb-5">
        <?= htmlspecialchars_decode($data['post']['content']) ?>
    </article>

    <div class="comments" style="max-width: 800px;">
        <div class="comment-list">
            <h4 class="mb-4">Comments</h4>
            <div id="comment-items"></div>
        </div>
        <button id="load-more-comments" class="btn btn-outline-secondary my-3"
                onclick="CommentModule.load(<?= (int)$data['post']['id'] ?>, 0, 5)"
                style="border: 0;">
            Load More Comments
        </button>
        <?php include_once "views/components/posts/commentForm.php" ?>
    </div>
    <?php $recommendedPosts = $this->recommendedPosts; include "views/components/posts/recommendedPosts.php" ?>
</section>
<script>
    const currentUserId = <?= isset($_SESSION['user']['id']) ? (int)$_SESSION['user']['id'] : 0 ?>;
    document.addEventListener("DOMContentLoaded", function () {
        CommentModule.load(<?= (int)$this->record['post']['id'] ?>);
    })
</script>
<?php include_once "views/layouts/user/footer.php" ?>