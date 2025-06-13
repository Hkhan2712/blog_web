function likePost(postId) {
    fetch('<?= AppUtil::url(['ctl' => 'like', 'act' => 'add']) ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ 
            postId: postId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Post liked successfully!');
            // Có thể cập nhật UI ở đây, ví dụ: tăng số lượt like
        } else {
            alert('Error liking post: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}
