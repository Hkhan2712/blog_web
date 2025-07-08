<?php class PTRepository {
    public static function getPostAndTags($postId) {
        $data = [];
        $post = PostModel::getInstance()->getRecord($postId);
        if (!$post) return false;

        $tags = PostTagModel::getInstance()->getTagsByPostId($postId);
        $data['post'] = $post;
        $data['tags'] = $tags;

        return $data;
    }
    public static function addTagToPost($postId, $tagId) {
        return PostTagModel::getInstance()->addTagToPost($postId, $tagId);
    }    
    public static function removeTagFromPost($postId, $tagId) {
        return PostTagModel::removeTagFromPost($postId, $tagId);
    }
}   