const LikeModule = (() => {
    const api = {
        like: urls.like,
    };
    const toggleLike = (entityId, entityType = 'post', btn) => { 
        if (!btn) return;

        const isLiked = btn.getAttribute('data-liked') === '1';
    
        const payload = {
            id: entityId,
            type: entityType
        };
        fetch(api.like, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(payload),
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                btn.setAttribute('data-liked', isLiked ? '0' : '1');
                btn.classList.toggle('btn-primary', !isLiked);
                btn.classList.toggle('btn-outline-primary', isLiked);
                btn.classList.toggle('text-white', !isLiked);

                const likeCountSpan = btn.querySelector('#like-count');
                if (likeCountSpan) {
                    likeCountSpan.innerText = res.like_quantity;
                }
            } else {
                alert(res.message || "Failed to toggle like.");
            }
        });
    };
    return {
        toggleLike
    };
})()