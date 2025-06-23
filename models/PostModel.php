<?php
class PostModel extends FrapModel {
    public $nopp = 10;
    public static $status = [
        0 => 'draft',
        1 => 'published',
        2 => 'pending',
        3 => 'archived'
    ];
    protected $relationships = [
        'belongTo' => [
            ['user', 'key' => 'user_id'],
            ['category', 'key' => 'category_id']
        ],
        'hasMany' => [
            ['comments', 'key' => 'post_id'],
            ['tags', 'key' => 'post_id', 'through' => 'post_tags']
        ]
    ];

    public function rules() {
        global $app;
	    return [
        	'title' 		=> [['required', 'errmsg'=>'Title can not bank!'], 'string', ['max', 'value'=>250]],
        	'slug' 		=> [['required', 'errmsg'=>'Slug can not bank!'], 
        					['unique',   'errmsg'=>'This value already existing! Slug should be unique!'], 
        					 'string', ['max', 'value'=>250]],
        	'content' 	=> [['required', 'errmsg'=>'Content can not bank!'], 'string'],
	        'status'	=> [['inlist', 'value'=>array_keys(self::$status)]]
	    ];
    }

    public function getOutstandingPost() {
        $sql = "SELECT posts.*, users.username AS author
                FROM posts
                JOIN users ON posts.user_id = users.id
                WHERE posts.created_at >= DATE_SUB(NOW(), INTERVAL 14 DAY)
                ORDER BY posts.like_quantity DESC
                LIMIT 1";
        $result = $this->con->query($sql);
        return $result->fetch_assoc();
    }

    public function getNewestPost($limit) {
        $limit = $this->nopp;
        $sql = "SELECT 
                    posts.*, 
                    users.username AS author_name,
                    GROUP_CONCAT(tags.name SEPARATOR ', ') AS tags
                FROM posts
                JOIN users ON posts.user_id = users.id
                LEFT JOIN post_tags ON posts.id = post_tags.post_id
                LEFT JOIN tags ON post_tags.tag_id = tags.id
                GROUP BY posts.id
                ORDER BY posts.created_at DESC
                LIMIT $limit";
        return $this->con->query($sql);
    }

    public function getListPosts($limit = 10, $offset = 0) {
        $sql = "SELECT 
            posts.*, 
            users.username AS author_name,
            GROUP_CONCAT(tags.name SEPARATOR ', ') AS tags
        FROM posts
        JOIN users ON posts.user_id = users.id
        LEFT JOIN post_tags ON posts.id = post_tags.post_id
        LEFT JOIN tags ON post_tags.tag_id = tags.id
        GROUP BY posts.id
        ORDER BY posts.created_at DESC
        LIMIT $limit OFFSET $offset;
        ";
        return $this->con->query($sql);
    }

    public function getPostById($id) {
        $sql = "SELECT 
                    posts.*, 
                    users.username AS author_name,
                    GROUP_CONCAT(tags.name SEPARATOR ', ') AS tags
                FROM posts
                JOIN users ON posts.user_id = users.id
                LEFT JOIN post_tags ON posts.id = post_tags.post_id
                LEFT JOIN tags ON post_tags.tag_id = tags.id
                WHERE posts.id = $id
                GROUP BY posts.id";
        
        return $this->con->query($sql)->fetch_assoc();
    }

    public function hasUserLiked($postId, $userId) {
        $postId = (int)$postId;
        $userId = (int)$userId;
        $sql = "SELECT id FROM likes WHERE entity_id = $postId AND user_id = $userId AND entity_type = 'post' LIMIT 1";
        $result = mysqli_query($this->con, $sql);
        return mysqli_num_rows($result) > 0;
    }

    public function countAllPosts() {
        $sql = "SELECT COUNT(1) as total FROM posts";
        $result = $this->con->query($sql);
        $row = $result->fetch_assoc();
        return (int)$row['total'];
    }

    public function getListPostsPaginate($limit, $offset) {
        $sql = "SELECT posts.*, users.username AS author_name
                FROM posts
                JOIN users ON posts.user_id = users.id
                ORDER BY posts.created_at DESC
                LIMIT ? OFFSET ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function getPostsByUserId($userId) {
        $sql = "SELECT id, title, `status`, created_at FROM posts where user_id = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function getRecommendedPosts($excludePostId, $limit = 3) {
        $sql = "SELECT 
                    posts.*, 
                    users.username AS author_name,
                    GROUP_CONCAT(tags.name SEPARATOR ', ') AS tags
                FROM posts
                JOIN users ON posts.user_id = users.id
                LEFT JOIN post_tags ON posts.id = post_tags.post_id
                LEFT JOIN tags ON post_tags.tag_id = tags.id
                WHERE posts.id != ?
                GROUP BY posts.id
                ORDER BY posts.created_at DESC
                LIMIT ?";
        
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ii", $excludePostId, $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}