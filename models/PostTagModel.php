<?php 
class PostTagModel extends CrudModel {
    protected $table = 'post_tags';
    public static function getTagsByPostId($postId) {
        $sql = "SELECT tags.id, tags.name 
                FROM post_tags 
                JOIN tags ON post_tags.tag_id = tags.id 
                WHERE post_tags.post_id = ?";
        $stmt = ConnectDB::getInstance()->getConnection()->prepare($sql);
        $stmt->bind_param("i", $postId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public static function addTagToPost($postId, $tagId) {
        $sql = "INSERT INTO post_tags (post_id, tag_id) VALUES (?, ?)";
        $stmt = ConnectDB::getInstance()->getConnection()->prepare($sql);
        $stmt->bind_param("ii", $postId, $tagId);
        return $stmt->execute();
    }

    public static function removeTagFromPost($postId, $tagId) {
        $sql = "DELETE FROM post_tags WHERE post_id = ? AND tag_id = ?";
        $stmt = ConnectDB::getInstance()->getConnection()->prepare($sql);
        $stmt->bind_param("ii", $postId, $tagId);
        return $stmt->execute();
    }
}