<?php
class PostCategoryModel extends CrudModel {
    public static function getCategoriesByPostId($postId) {
        $sql = "SELECT categories.* 
                FROM post_categories 
                JOIN categories ON post_categories.category_id = categories.id 
                WHERE post_categories.post_id = ?";
        $stmt = ConnectDB::getInstance()->getConnection()->prepare($sql);
        $stmt->bind_param("i", $postId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function getPostsByCategoryId($categoryId) {
        $sql = "SELECT posts.* 
                FROM post_categories 
                JOIN posts ON post_categories.post_id = posts.id 
                WHERE post_categories.category_id = ?";
        $stmt = ConnectDB::getInstance()->getConnection()->prepare($sql);
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function addPostToCategory($postId, $categoryId) {
        $sql = "INSERT INTO post_categories (post_id, category_id) VALUES (?, ?)";
        $stmt = ConnectDB::getInstance()->getConnection()->prepare($sql);
        $stmt->bind_param("ii", $postId, $categoryId);
        return $stmt->execute();
    }

    public static function removePostFromCategory($postId, $categoryId) {
        $sql = "DELETE FROM post_categories WHERE post_id = ? AND category_id = ?";
        $stmt = ConnectDB::getInstance()->getConnection()->prepare($sql);
        $stmt->bind_param("ii", $postId, $categoryId);
        return $stmt->execute();
    }
}
