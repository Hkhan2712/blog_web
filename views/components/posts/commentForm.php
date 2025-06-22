<?php if (!isset($_SESSION['user'])): ?>
    <div class="alert alert-warning" role="alert">
        You need to be logged in to comment.
    </div>
<?php else: ?>
    <div class="d-flex gap-3 w-100">
        <?php if (!empty($_SESSION['user']['avatar_url'])): ?>
            <img src="<?= RootREL . "media/uploads/users/" . $_SESSION['user']['avatar_url'] ?>" alt="" class="rounded-circle" width="30" height="30">
        <?php endif; ?>
        <form id="comment-form" action="javascript:void(0)" method="POST" style="flex-grow: 1;">
            <div class="mb-3">
                <textarea id="comment-content" class="form-control" name="content" rows="3" required placeholder="Write your comment here..."></textarea>
            </div>
            <button type="button" id="comment-btn" onclick="CommentModule.commentPost(<?= (int)$postId ?>)" class="btn btn-primary">Submit Comment</button>
        </form>
    </div>
<?php endif; ?>
