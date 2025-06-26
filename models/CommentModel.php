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
    public function getCommentsByPostId($postId, $limit = 5) {
        $postId = (int)$postId;
        $limit = (int)$limit;
        $sql = "SELECT comments.*, users.username AS author_name, users.avatar_url as author_avatar
                FROM comments 
                JOIN users ON comments.user_id = users.id 
                WHERE comments.post_id = ? and parent_id is null
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
    public function incrementCommentQuantity($postId) {
        $sql = "UPDATE posts SET comment_quantity = comment_quantity + 1 WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $postId);
        $stmt->execute();
    }
    public function updatePath($commentId, $path) {
        $sql = "UPDATE {$this->table} SET path = ? WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('si', $path, $commentId);
        return $stmt->execute();
    }
    public function getCommentsWithPagination($postId, $limit = 5, $offset = 0) {
        $sql = "SELECT c.*, u.username AS author, u.avatar_url AS avatar
                FROM {$this->table} c
                JOIN users u ON c.user_id = u.id
                WHERE c.post_id = ? AND c.parent_id = 0
                ORDER BY c.created_at DESC
                LIMIT ? OFFSET ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("iii", $postId, $limit, $offset);
        $stmt->execute();

        $result = $stmt->get_result();
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $row['has_reply'] = $this->hasReplies($row['id']);
            $data[] = $row;
        }
        $stmt->close();
        return $data;
    }

    public function hasReplies($parentId) {
        $sql = "SELECT COUNT(1) as cnt FROM {$this->table} WHERE parent_id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $parentId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result['cnt'] > 0;
    }

    public function getRepliesWithPagination($parentId, $limit = 5, $offset = 0) {
        $sql = "SELECT c.*, u.username AS author, u.avatar_url AS avatar
                FROM {$this->table} c
                JOIN users u ON c.user_id = u.id
                WHERE c.parent_id = ?
                ORDER BY c.created_at ASC
                LIMIT ? OFFSET ?";
        $stmt = $this->con->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->con->error);
        }

        $stmt->bind_param("iii", $parentId, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        $stmt->close();
        // var_dump($rows);
        return $rows;
    }
    public function incrementCommentQuantityOfParent($parentId) {
        $sql = "UPDATE {$this->table} SET child_comment_quantity = child_comment_quantity + 1 WHERE id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $parentId);
        return $stmt->execute();
    }
    public static function checkLiked($comment, $userId) {
        if (!$userId) {
            return false;
        }
        $cm = self::getInstance();
        return $cm->hasUserLikedCm($comment, $userId);
    }
}