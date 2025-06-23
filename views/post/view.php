<?php
/** @var array $mediaFiles */
global $mediaFiles;
array_push($mediaFiles['css'], RootREL . 'media/css/post.css');
array_push($mediaFiles['js'], RootREL . 'media/js/comment.js');

$post = $this->record;
$isLoggedIn = isset($_SESSION['user']);
?>

<?php include_once "views/layouts/user/header.php" ?>

<section class="container py-5">
    <?php include_once "views/components/posts/postHeader.php" ?>

    <article class="content pt-4 pb-5">
        <?= htmlspecialchars_decode($this->record['content']) ?>
    </article>

    <div class="comments" style="max-width: 800px;">
        <div class="comment-list">
            <h4 class="mb-4">Comments</h4>
            <div id="comment-items"></div>
        </div>
        <button id="load-more-comments" class="btn btn-outline-secondary my-3"
                onclick="CommentModule.loadComment(<?= (int)$post['id'] ?>)"
                style="border: 0;">
            Load More Comments
        </button>
        <?php $postId = $this->record['id']; include "views/components/posts/commentForm.php" ?>
    </div>
    <?php $recommendedPosts = $this->recommendedPosts; include "views/components/posts/recommendedPosts.php" ?>
</section>

<script>
    const likeUrl = '<?= AppUtil::url(['ctl' => 'like', 'act' => 'add']) ?>';
    const likeCmUrl = '<?= AppUtil::url(['ctl' => 'like', 'act' => 'addLikeCm']) ?>';
    const currentUserId = <?= $isLoggedIn ? (int)$_SESSION['user']['id'] : 0 ?>;
    const commentUrl = '<?= AppUtil::url(['ctl' => 'comment', 'act' => 'add']) ?>';
    const replyUrl = '<?= AppUtil::url(['ctl' => 'comment', 'act' => 'reply']) ?>';
    const loadReplyUrl = '<?= AppUtil::url(['ctl' => 'comment', 'act' => 'loadRep'])?>';
    const commentLoadUrl = '<?= AppUtil::url(['ctl' => 'comment', 'act' => 'loadComment'])?>';

</script>
<?php include_once "views/layouts/user/footer.php" ?>