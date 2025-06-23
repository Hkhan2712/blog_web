<?php
class LikeRepository {
    protected $con;
    
    public function __construct($con) {
        $this->con = $con;
    }

    public function hasUserLikedPost($postId, $userId) {
        $sql = "SELECT id FROM likes WHERE entity_id = ? AND user_id = ? AND entity_type = 'post' LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("ii", $postId, $userId);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }
}
