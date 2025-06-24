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
    public function getRecordsWhereNotId($excludePostId, $limit = 3) {
        $sql = "SELECT * FROM posts WHERE id != ? ORDER BY created_at DESC LIMIT ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ii", $excludePostId, $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}