<?php 
class PostService {
    public static function getOutstandingPost() {
        $postModel = new PostModel();
        return $postModel->getOutstandingPost();
    }
    public static function getNewestPosts($limit = 10) {
        $postModel = new PostModel();
        return $postModel->getNewestPost($limit);
    }
    public static function getListPosts($limit = 10, $offset = 0) {
        $postModel = new PostModel();
        return $postModel->getListPosts($limit, $offset);   
    }
}