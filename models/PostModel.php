<?php
class PostModel extends FrapModel {
    public $nopp = 20;
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
        $sql = "SELECT posts.*, users.username AS author_name
                FROM posts
                JOIN users ON posts.user_id = users.id
                WHERE posts.created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                ORDER BY posts.like_quantity DESC
                LIMIT 1";
        
        $result = $this->con->query($sql);
        return $result->fetch_assoc();
    }

    public function getNewestPost($limit = 10) {
        $limit = (int)$limit;
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

    public function getListPosts($limit = 20, $offset = 0) {
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
}