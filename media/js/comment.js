const CommentModule = (() => {
    if (!urls.store || !urls.load) {
        console.error("CommentModule: Missing API URLs.");
        return;
    }

    const api = {
        store: urls.store,
        load: urls.load
    };

    function escapeHtml(str) {
        return str.replace(/[&<>"']/g, match => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        })[match]);
    }

    function removeForm(parentId) {
        const form = document.querySelector(`#comment-form-${parentId}`);
        if (form) form.remove();
    }

    function showForm(postId, parentId = 0) {
        removeForm(parentId);
        const container = parentId ? document.querySelector(`#replies-${parentId}`) : document.querySelector("#comment-items");
        if (!container) return;

        const html = `
            <form id="comment-form-${parentId}" class="mt-2" onsubmit="CommentModule.submit(event, ${postId}, ${parentId})">
                <textarea class="form-control mb-2" rows="3" placeholder="${parentId ? 'Reply...' : 'Write a comment...'}" required></textarea>
                <button class="btn btn-sm btn-primary">Submit</button>
                <button type="button" class="btn btn-sm btn-secondary ms-2" onclick="CommentModule.removeForm(${parentId})">Cancel</button>
            </form>
        `;
        container.insertAdjacentHTML("beforeend", html);
    }

    async function submit(event, postId, parentId = 0) {
        event.preventDefault();
        const form = event.target;
        const textarea = form.querySelector("textarea");
        const content = textarea.value.trim();
        if (!content) return alert("Content cannot be empty");

        try {
            const res = await fetch(api.store, {
                method: "POST",
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ postId, parentId, content })
            });

            if (!res.ok) throw new Error("Failed to submit comment");

            const result = await res.json();
            if (result.success) {
                const html = renderComment(result.data, parentId > 0);
                const container = parentId ? document.querySelector(`#replies-${parentId}`) : document.querySelector("#comment-items");
                container.insertAdjacentHTML("beforeend", html);
                removeForm(parentId);
            } else {
                alert(result.message || "Failed to submit comment");
            }
        } catch (err) {
            console.error("Submit error:", err);
            alert("An error occurred while submitting the comment.");
        }
    }

    let commentOffset = 0;
    const COMMENT_LIMIT = 5;
    const replyOffsets = {};
    const replyTotal = {};

    async function load(postId, parentId = 0, offset = null, limit = COMMENT_LIMIT) {
        if (parentId === 0) {
            offset = offset !== null ? offset : commentOffset;
        } else {
            replyOffsets[parentId] = replyOffsets[parentId] || 0;
            offset = offset !== null ? offset : replyOffsets[parentId];
        }

        const container = parentId
            ? document.querySelector(`#replies-list-${parentId}`)
            : document.querySelector("#comment-items");

        if (!container) return;

        try {
            const res = await fetch(api.load, {
                method: "POST",
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(parentId ? { parentId, offset, limit } : { postId, offset, limit })
            });

            const result = await res.json();
            if (result.success) {
                if (result.data.length === 0 && offset === 0) {
                    container.innerHTML += `<p class="text-muted">No replies yet.</p>`;
                    return;
                }

                result.data.forEach(comment => {
                    const commentId = comment.id;
                    if (!document.getElementById(`${parentId ? 'reply' : 'comment'}-${commentId}`)) {
                        if (!comment.postId) comment.postId = postId;
                        const html = renderComment(comment, parentId > 0);
                        container.insertAdjacentHTML("beforeend", html);
                    }
                });

                if (parentId === 0) {
                    commentOffset += result.data.length;
                    if (result.data.length < limit) {
                        document.getElementById("load-more-comments")?.remove();
                    } else {
                        document.getElementById("load-more-comments")?.setAttribute(
                            "onclick", `CommentModule.load(${postId}, 0, ${commentOffset})`
                        );
                    }
                } else {
                    replyOffsets[parentId] += result.data.length;
                    const remaining = (replyTotal[parentId] || 0) - replyOffsets[parentId];
                    const btn = document.getElementById(`load-more-replies-${parentId}`);
                    if (remaining <= 0) {
                        btn?.remove();
                    } else if (btn) {
                        btn.innerText = `Show ${Math.min(COMMENT_LIMIT, remaining)} of ${remaining} more replies`;
                        btn.setAttribute("onclick", `CommentModule.load(${postId}, ${parentId}, ${replyOffsets[parentId]}, ${limit})`);
                    }
                }

            } else {
                alert("Failed to load comments");
            }
        } catch (err) {
            console.error("Load comments failed", err);
        }
    }

    
    function renderComment(comment, isReply = false) {
        const createdAt = new Date(comment.created_at).toLocaleDateString('en-US', {
            year: 'numeric', month: 'long', day: '2-digit'
        });

        if (!isReply && comment.child_comment_quantity > 0) {
            replyTotal[comment.id] = comment.child_comment_quantity;
        }

        const isLiked = comment.is_liked ? '1' : '0';
        const likeClass = comment.is_liked ? 'btn-primary text-white' : 'btn-outline-secondary';

        return `
            <div class="${isReply ? 'reply-item' : 'comment-item'} mb-3" id="${isReply ? 'reply' : 'comment'}-${comment.id}">
                <div class="d-flex gap-2 align-items-start">
                    <img src="/media/uploads/users/${comment.avatar || 'default.png'}"
                        class="rounded-circle"
                        width="${isReply ? 25 : 30}" height="${isReply ? 25 : 30}">
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <strong>${escapeHtml(comment.author)}</strong>
                            <span class="text-muted small">${createdAt}</span>
                        </div>
                        <p class="mb-1">${escapeHtml(comment.content)}</p>
                        <div class="d-flex gap-2 align-items-center">
                            <button class="btn btn-sm ${likeClass} border-0 d-flex align-items-center gap-1" data-liked="${isLiked}" onclick="LikeModule.toggleLike(${comment.id}, 'comment', this)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-hand-thumbs-up" viewBox="0 0 16 16">
                                    <path d="M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2 2 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a10 10 0 0 0-.443.05 9.4 9.4 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111z"/>
                                </svg>
                                <span id="like-count">${comment.like_quantity || 0}</span>
                            </button>
                            <button class="btn btn-sm btn-outline-secondary"
                                    onclick="CommentModule.showForm(${comment.postId}, ${comment.id})"
                                    style="border: 0;">Reply</button>
                        </div>

                        <div class="ms-4 mt-2" id="replies-${comment.id}">
                            <div id="replies-list-${comment.id}"></div>
                            ${comment.child_comment_quantity > 0 ? `
                                <button id="load-more-replies-${comment.id}" class="btn btn-sm p-1"
                                    onclick="CommentModule.load(${comment.postId}, ${comment.id}, 0, ${COMMENT_LIMIT})">
                                    Show ${Math.min(COMMENT_LIMIT, comment.child_comment_quantity)} of ${comment.child_comment_quantity} replies
                                </button>
                            ` : ''}
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        `;
    }

    return {
        showForm,
        submit,
        load,
        removeForm
    };
})(window.urls || {});