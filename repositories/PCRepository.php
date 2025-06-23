<?php 
class PCRepository {
    public static function getCategoryAndPosts($categoryId) {
        $data = [];
        $categoryId = (int)$categoryId;
        $category = CategoryModel::getInstance()->getRecord($categoryId);
        if (!$category) return false;

        $posts = PostCategoryModel::getInstance()->getPostsByCategoryId($categoryId);

        foreach ($posts as &$post) {
            $user = UserModel::getInstance()->getRecord($post['user_id']);
            $post['author'] = $user ? $user['username'] : 'Unknown';
            $post['author_avatar'] = $user['avatar_url'] ?? null;
        }
        unset($post);

        $data['category'] = $category;
        $data['posts'] = $posts;

        return $data;
    }

    public static function addPostToCategory($postId, $categoryId) {
        return PostCategoryModel::getInstance()->addPostToCategory($postId, $categoryId);
    }    
    public static function removePostFromCategory($postId, $categoryId) {
        return PostCategoryModel::removePostFromCategory($postId, $categoryId);
    }
}