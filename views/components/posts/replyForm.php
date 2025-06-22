<form id="reply-form-<?= (int)$parentId ?>" onsubmit="submitReply(<?= (int)$parentId ?>, <?= (int)$postId ?>); return false;" class="mt-2">
    <textarea id="reply-content-<?= (int)$parentId ?>" class="form-control mb-2" rows="2" required placeholder="Write your reply..."></textarea>
    <button type="submit" class="btn btn-sm btn-primary">Reply</button>
    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="hideReplyForm(<?= (int)$parentId ?>)">Cancel</button>
</form>