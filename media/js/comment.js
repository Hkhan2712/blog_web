const CommentModule = (() => {
    const selectors = {
        commentList: ".comment-list",
        commentCount: "#comment-count",
        commentForm: "#comment-form",
        commentContent: "#comment-content",
        repliesContainer: (commentId) => `#replies-${commentId}`,
        replyForm: (commentId) => `#reply-form-${commentId}`,
        commentItem: (id) => `#comment-${id}`,
        replyItem: (id) => `#reply-${id}`
    };

    const apiUrls = {
        comment: commentUrl,     
        reply: replyUrl,         
        likePost: likeUrl,       
        likeComment: likeCmUrl,  
        loadReply: loadReplyUrl
    };

    function updateCommentCount(increment = 1) {
        const countElement = document.querySelector(selectors.commentCount);
        if (countElement) {
            let current = parseInt(countElement.textContent);
            countElement.textContent = current + increment;
        }
    }

    function createCommentHTML(comment) {
        return `
            <div class="comment-item mb-3" id="comment-${comment.id}">
                <div class="d-flex gap-3 align-items-start">
                    <div class="avatar">
                        <img src="/media/uploads/users/${comment.avatar}" class="rounded-circle" width="30" height="30">
                    </div>
                    <div class="comment-content flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="m-0">${comment.author}</h5>
                            <span class="text-muted">${comment.created_at}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <p>${comment.content}</p>
                            ${currentUserId ? `
                            <div class="d-flex gap-2">
                                <button class="btn btn-sm btn-outline-secondary" onclick="CommentModule.showReplyForm(${comment.id})" style="border: 0;">Reply</button>
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
                        id="show-replies-<?= (int)$comment['id'] ?>" 
                        style="border: 0;"
                        onclick="CommentModule.loadReplies(${comment.id})">
                    Show Replies
                </button>
                ` : ''}
                <hr>
            </div>
        `;
    }

    function createReplyHTML(reply) {
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
                                <button class="btn btn-sm btn-outline-secondary" onclick="CommentModule.showReplyForm(${reply.id}, ${reply.postId})" style="border: 0;">Reply</button>
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
    }

    async function commentPost(postId) {
        const content = document.querySelector(selectors.commentContent).value.trim();
        if (!content) return alert("Comment cannot be empty");
        console.log(selectors.commentContent);
        const response = await fetch(apiUrls.comment, {
            method: "POST",
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ postId: postId, content })
        });
        const result = await response.json();

        if (result.success) {
            document.querySelector(selectors.commentList).insertAdjacentHTML("afterend", createCommentHTML(result.data));
            document.querySelector(selectors.commentContent).value = "";
            updateCommentCount();
        } else {
            alert(result.json && result.message || "Failed to add comment");
        }
    }

    function showReplyForm(commentId, postId) {
        const container = document.querySelector(selectors.repliesContainer(commentId));
        if (!container) return;

        // If already has form → focus
        if (document.querySelector(selectors.replyForm(commentId))) {
            document.querySelector(`${selectors.replyForm(commentId)} textarea`).focus();
            return;
        }

        const formHTML = `
            <form id="reply-form-${commentId}" 
                  onsubmit="CommentModule.replyComment(event, ${postId}, ${commentId})" class="mt-2">
                <div class="mb-2">
                    <textarea class="form-control" rows="2" required placeholder="Write a reply..."></textarea>
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Submit Reply</button>
                <button type="button" class="btn btn-sm btn-secondary ms-2" onclick="CommentModule.removeReplyForm(${commentId})">Cancel</button>
            </form>
        `;
        container.insertAdjacentHTML("afterbegin", formHTML);
    }

    function removeReplyForm(commentId) {
        const form = document.querySelector(selectors.replyForm(commentId));
        if (form) form.remove();
    }

    async function replyComment(event, postId, commentId) {
        event.preventDefault();
        const textarea = event.target.querySelector("textarea");
        const content = textarea.value.trim();
        if (!content) return alert("Reply cannot be empty");

        const response = await fetch(apiUrls.reply, {
            method: "POST",
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ postId: postId, commentId: commentId, content })
        });
        const result = await response.json();

        if (result.success) {
            document.querySelector(selectors.repliesContainer(commentId)).insertAdjacentHTML("beforeend", createReplyHTML(result.data));
            removeReplyForm(commentId);
        } else {
            alert(result.message || "Failed to add reply");
        }
    }

    async function likePost(postId) {
        const response = await fetch(apiUrls.likePost, {
            method: "POST",
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ postId : postId })
        });
        const result = await response.json();

        if (result.success) {
            const likeCountEl = document.querySelector("#like-count");
            if (likeCountEl) likeCountEl.textContent = parseInt(likeCountEl.textContent) + 1;
            const btn = document.querySelector("#like-btn");
            if (btn) {
                btn.classList.remove("btn-outline-primary");
                btn.classList.add("btn-primary");
                btn.disabled = true;
                btn.querySelector(".like-text").textContent = "Liked";
            }
        } else {
            alert(result.message || "Failed to like post");
        }
    }

    async function likeComment(commentId) {
        const response = await fetch(apiUrls.likeComment, {
            method: "POST",
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ commentId: commentId })
        });
        const result = await response.json();

        if (result.success) {
            const btn = document.querySelector(`#like-comment-${commentId}`);
            if (btn) {
                btn.classList.remove("btn-outline-secondary");
                btn.classList.add("btn-primary");
                btn.disabled = true;
            }
        } else {
            alert(result.message || "Failed to like comment");
        }
    }

    async function loadComment() {

    }
    async function loadReplies(commentId, offset = 0, limit = 5) {
        const repliesContainer = document.querySelector(selectors.repliesContainer(commentId));
        const btn = document.querySelector(`#show-replies-${commentId}`);
        if (!repliesContainer || !btn) return;

        btn.textContent = "Loading...";

        try {
            const response = await fetch(apiUrls.loadReply, {
                method: "POST",
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ commentId, offset, limit })
            });
            const result = await response.json();
            if (result.success) {
                result.data.forEach(reply => {
                    repliesContainer.insertAdjacentHTML("beforeend", createReplyHTML(reply));
                });
                if (result.data.length < limit) {
                    btn.remove(); 
                } else {
                    btn.textContent = "Load More Replies";
                    btn.setAttribute("onclick", `CommentModule.loadReplies(${commentId}, ${offset + limit}, ${limit})`);
                }
            } else {
                btn.textContent = "Load More Replies";
                alert(result.message || "Failed to load replies");
            }
        } catch (e) {
            btn.textContent = "Load More Replies";
            alert("Failed to load replies");
        }
    }


    return {
        commentPost,
        showReplyForm,
        removeReplyForm,
        replyComment,
        likePost,
        likeComment,
        loadComment,
        loadReplies
    };
})();