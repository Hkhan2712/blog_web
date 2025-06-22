<div class="comment-item mb-3" id="comment-<?= (int)$comment['id'] ?>">
    <div class="d-flex gap-3 align-items-start">
        <div class="avatar">
            <img src="<?= RootREL . "media/uploads/users/" . htmlspecialchars($comment['author_avatar']) ?>" alt="" class="rounded-circle" width="30" height="30">
        </div>
        <div class="comment-content flex-grow-1">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="m-0"><?= htmlspecialchars($comment['author_name']) ?></h5>
                <span class="text-muted"><?= date("F d, Y", strtotime($comment['created_at'])) ?></span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <p><?= htmlspecialchars($comment['content']) ?></p>
                <?php if ($isLoggedIn): ?>
                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-outline-secondary" onclick="CommentModule.showReplyForm(<?= (int)$comment['id'] ?>, <?= (int)$postId ?>)" style="border: 0;">Reply</button>
                    <a id="like-comment-<?= (int)$comment['id'] ?>" class="btn btn-sm <?= $comment['is_liked'] ? 'btn-primary' : 'btn-outline-secondary' ?>" onclick="<?= !$comment['is_liked'] ? 'CommentModule.likeComment(' . (int)$comment['id'] . ')' : '' ?>" style="border: 0;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-up-fill" viewBox="0 0 16 16">
                            <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a10 10 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733q.086.18.138.363c.077.27.113.567.113.856s-.036.586-.113.856c-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.2 3.2 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.8 4.8 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
                        </svg>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="replies ms-5" id="replies-<?= (int)$comment['id'] ?>"></div>
    <button class="btn btn-sm btn-outline-secondary" 
        id="show-replies-<?= (int)$comment['id'] ?>" 
        style="border: 0;"
        onclick="CommentModule.loadReplies(<?= (int)$comment['id'] ?>)">
        Show Replies
    </button>
    <hr>
</div>