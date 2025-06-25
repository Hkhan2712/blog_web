const CommentModule = (() => {
    const api = {
        store: storeCmUrl,
        load: loadCmUrl,
    };

    const selectors = {
        commentList: ".comment-list",
        commentCount: "#comment-count",
        commentForm: "#comment-form",
        commentContent: "#comment-content",
        repliesContainer: id => `#replies-${id}`,
        replyForm: id => `#reply-form-${id}`,
        commentItem: id => `#comment-${id}`,
        replyItem: id => `#reply-${id}`
    };

    const UI = {
        renderComment(comment) {
            const createdAt = new Date(comment.created_at).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: '2-digit'
            });
            return `
            <div class="comment-item mb-3" id="comment-${comment.id}">
                <div class="d-flex gap-3 align-items-start">
                    <div class="avatar">
                        <img src="/media/uploads/users/${comment.avatar}" class="rounded-circle" width="30" height="30">
                    </div>
                    <div class="comment-content flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="m-0">${comment.author}</h5>
                            <span class="text-muted">${createdAt}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <p>${comment.content}</p>
                            ${currentUserId ? `
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-secondary" onclick="CommentModule.showReplyForm(${comment.id}, ${comment.post_id})" style="border: 0;">Reply</button>
                                <a id="like-comment-${comment.id}" class="btn btn-sm btn-outline-secondary" onclick="CommentModule.likeComment(${comment.id})" style="border: 0;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-up-fill" viewBox="0 0 16 16">
                                        <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a10 10 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733q.086.18.138.363c.077.27.113.567.113.856s-.036.586-.113.856c-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.2 3.2 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.8 4.8 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
                                    </svg>
                                </a>
                            </div>` : ''}
                        </div>
                    </div>
                </div>
                <div class="replies ms-5" id="replies-${comment.id}"></div>
                ${comment.has_reply ? `
                <button class="btn btn-sm btn-outline-secondary" 
                        id="show-replies-${comment.id}" 
                        style="border: 0;"
                        onclick="CommentModule.loadReplies(${comment.id})">
                    Show Replies
                </button>
                ` : ''}
                <hr>
            </div>
        `;
        },

        renderReply(reply) {
            const createdAt = new Date(reply.created_at).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: '2-digit'
        });

        return `
            <div class="reply-item mb-2" id="reply-${reply.id}">
                <div class="d-flex gap-2 align-items-start">
                    <div class="avatar">
                        <img src="/media/uploads/users/${reply.avatar}" class="rounded-circle" width="25" height="25">
                    </div>
                    <div class="reply-content">
                        <div class="d-flex justify-content-between align-items-center mb-1 gap-2">
                            <strong>${reply.author}</strong>
                            <span class="text-muted small">${createdAt}</span>
                        </div>
                        <p class="mb-0 small">${reply.content}</p>
                        ${currentUserId ? `
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-secondary" onclick="CommentModule.showReplyForm(${reply.id}, ${reply.post_id})" style="border: 0;">Reply</button>
                                <a id="like-comment-${reply.id}" class="btn btn-sm btn-outline-secondary" onclick="CommentModule.likeComment(${reply.id})" style="border: 0;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-up-fill" viewBox="0 0 16 16">
                                        <path d="M6.956 1.745C7.021.81 7.908.087 8.864.325l.261.066c.463.116.874.456 1.012.965.22.816.533 2.511.062 4.51a10 10 0 0 1 .443-.051c.713-.065 1.669-.072 2.516.21.518.173.994.681 1.2 1.273.184.532.16 1.162-.234 1.733q.086.18.138.363c.077.27.113.567.113.856s-.036.586-.113.856c-.039.135-.09.273-.16.404.169.387.107.819-.003 1.148a3.2 3.2 0 0 1-.488.901c.054.152.076.312.076.465 0 .305-.089.625-.253.912C13.1 15.522 12.437 16 11.5 16H8c-.605 0-1.07-.081-1.466-.218a4.8 4.8 0 0 1-.97-.484l-.048-.03c-.504-.307-.999-.609-2.068-.722C2.682 14.464 2 13.846 2 13V9c0-.85.685-1.432 1.357-1.615.849-.232 1.574-.787 2.132-1.41.56-.627.914-1.28 1.039-1.639.199-.575.356-1.539.428-2.59z"/>
                                    </svg>
                                </a>
                            </div>` : ''}
                    </div>
                </div>
                <div class="replies ms-5" id="replies-${reply.id}"></div>
            </div>
        `;
        },

        updateCommentCount(delta = 1) {
            const el = document.querySelector(selectors.commentCount);
            if (el) el.textContent = parseInt(el.textContent) + delta;
        },

        showReplyForm(commentId, postId) {
            const container = document.querySelector(selectors.repliesContainer(commentId));
            if (!container) return;
            if (document.querySelector(selectors.replyForm(commentId))) {
                document.querySelector(`${selectors.replyForm(commentId)} textarea`).focus();
                return;
            }
            container.insertAdjacentHTML("afterbegin", `
                <form id="reply-form-${commentId}" onsubmit="CommentModule.handleReply(event, ${postId}, ${commentId})" class="mt-2">
                    <textarea class="form-control mb-2" rows="2" required placeholder="Write a reply..."></textarea>
                    <button class="btn btn-sm btn-primary">Submit</button>
                    <button type="button" class="btn btn-sm btn-secondary ms-2" onclick="CommentModule.removeReplyForm(${commentId})">Cancel</button>
                </form>
            `);
        },

        removeReplyForm(commentId) {
            const form = document.querySelector(selectors.replyForm(commentId));
            if (form) form.remove();
        }
    };

    const Service = {
        async postComment(postId, content) {
            const res = await fetch(api.store, {
                method: "POST",
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ postId, content })
            });
            return res.json();
        },

        async replyToComment(postId, commentId, content) {
            const res = await fetch(api.store, {
                method: "POST",
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ postId, parentId: commentId, content })
            });
            return res.json();
        },

        async loadComments(postId, offset = 0, limit = 5) {
            const res = await fetch(api.load, {
                method: "POST",
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ postId, offset, limit })
            });
            return res.json();
        },

        async loadReplies(commentId, offset = 0, limit = 5) {
            const res = await fetch(api.load, {
                method: "POST",
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ commentId, offset, limit })
            });
            return res.json();
        }
    };

    const Events = {
        async handleCommentSubmit(event, postId) {
            event.preventDefault();
            const content = document.querySelector(selectors.commentContent).value.trim();
            if (!content) return alert("Comment cannot be empty");

            const result = await Service.postComment(postId, content);
            if (result.success) {
                document.querySelector(selectors.commentList)
                        .insertAdjacentHTML("afterend", UI.renderComment(result.data));
                document.querySelector(selectors.commentContent).value = "";
                UI.updateCommentCount(1);
            } else {
                alert(result.message || "Failed to add comment");
            }
        },

        async handleReply(event, postId, commentId) {
            event.preventDefault();
            const textarea = event.target.querySelector("textarea");
            const content = textarea.value.trim();
            if (!content) return alert("Reply cannot be empty");

            const result = await Service.replyToComment(postId, commentId, content);
            if (result.success) {
                document.querySelector(selectors.repliesContainer(commentId))
                    .insertAdjacentHTML("beforeend", UI.renderReply(result.data));
                UI.removeReplyForm(commentId);
            } else {
                alert(result.message || "Failed to add reply");
            }
        },

        async loadMoreComments(postId, offset = 0, limit = 5) {
            const result = await Service.loadComments(postId, offset, limit);
            if (result.success) {
                const container = document.querySelector("#comment-items");
                result.data.forEach(c => container.insertAdjacentHTML("beforeend", UI.renderComment(c)));
            }
        },

        async loadMoreReplies(commentId, offset = 0, limit = 5) {
            const btn = document.querySelector(`#show-replies-${commentId}`);
            const container = document.querySelector(selectors.repliesContainer(commentId));
            btn.textContent = "Loading...";
            const result = await Service.loadReplies(commentId, offset, limit);
            if (result.success) {
                result.data.forEach(r => container.insertAdjacentHTML("beforeend", UI.renderReply(r)));
                if (result.data.length < limit) btn.remove();
                else {
                    btn.textContent = "Load More Replies";
                    btn.setAttribute("onclick", `CommentModule.loadMoreReplies(${commentId}, ${offset + limit}, ${limit})`);
                }
            } else {
                alert("Failed to load replies");
            }
        },

        init(postId) {
            document.querySelector(selectors.commentForm)
                .addEventListener("submit", e => Events.handleCommentSubmit(e, postId));
        }
    };

    return {
        init: Events.init,
        showReplyForm: UI.showReplyForm,
        removeReplyForm: UI.removeReplyForm,
        handleReply: Events.handleReply,
        loadMoreReplies: Events.loadMoreReplies
    };
})();
