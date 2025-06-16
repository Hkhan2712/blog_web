<?php 
class CommentModel extends CrudModel {
    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $relationships = [
        'belongTo' => [
            ['user', 'key' => 'user_id'],
            ['post', 'key' => 'post_id']
        ]
    ];  
    public function rules() {
        return [
            'user_id' => [['required', 'errmsg' => 'User ID is required'], 'integer'],
            'post_id' => [['required', 'errmsg' => 'Post ID is required'], 'integer'],
            'content' => [['required', 'errmsg' => 'Content cannot be empty'], 'string']
        ];
    }
    public function addComment($userId, $postId, $content) {
        if (!$userId || !$postId || !$content) {
            return false;
        }
        $data = [
            'user_id' => $userId,
            'post_id' => $postId,
            'content' => $content,
        ];

        $result = $this->addRecord($data);
        if ($result) {
            $this->incrementCommentQuantity($postId);
        }
        return $result;
    }
    public function getCommentsByPostId($postId, $limit = 10) {
        $postId = (int)$postId;
        $limit = (int)$limit;
        $sql = "SELECT comments.*, users.username AS author_name, users.avatar_url as author_avatar
                FROM comments 
                JOIN users ON comments.user_id = users.id 
                WHERE comments.post_id = ? 
                ORDER BY comments.created_at DESC 
                LIMIT ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ii", $postId, $limit);
        $stmt->execute();
        return $stmt->get_result();
    }
    public function deleteComment($commentId, $userId) {
        $commentId = (int)$commentId;
        $userId = (int)$userId;
        $comment = $this->getRecord(['id' => $commentId, 'user_id' => $userId]);
        if (!$comment) {
            return false; 
        }
        return $this->delRecord($commentId);
    }
    public function countCommentsForPost($postId) {
        $postId = (int)$postId;
        $sql = "SELECT COUNT(1) as total FROM comments WHERE post_id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $postId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return (int)$row['total'];
    }
    public function hasUserLikedCm($commentId, $userId)
    {
        $sql = "SELECT COUNT(1) FROM likes WHERE entity_type = 'comment' AND entity_id = ? AND user_id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ii", $commentId, $userId);
        $count = $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        return $count > 0;
    }
    private function incrementCommentQuantity($postId) {
        $sql = "UPDATE posts SET comment_quantity = comment_quantity + 1 WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $postId);
        $stmt->execute();
    }
    public function updatePath($commentId, $path) {
        $sql = "UPDATE comments set path = ? where id = $commentId";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $path);
        $stmt->execute();
    }
}