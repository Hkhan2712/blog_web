<?php 
class PostRepository
{
    public static function getRecommendedPosts($postId, $limit = 3)
    {
        $posts = PostModel::getInstance()->getRecordsWhereNotId($postId, $limit);
        $data = [];
        foreach ($posts as $post) {
            $user = PURepository::getUserByPostId($post['id']);
            if ($user) {
                $post['user'] = $user;
                $data[] = $post;
            }
        }
        if (empty($data)) {
            header('HTTP/1.0 404 Not Found');
            exit('No recommended posts found or users missing.');
        }

        return $data;
    }
    public static function getOutstandingPost(){
        $data = PostModel::getInstance()->getRecordsAdvanced('*', [], [
            'order' => '(like_quantity + comment_quantity) DESC, created_at DESC',
            'limit' => 1
        ]);
        $data = $data[0];
        $data['user'] = PURepository::getUserByPostId($data['id']);
        if (!$data['user']) {
            header('HTTP/1.0 404 Not Found');
            exit('User not found for the outstanding post.');   
        }
        return $data;
    }
    public static function getNewestPosts($limit = 10)
    {
        $data = PostModel::getInstance()->getRecordsAdvanced('*', [], [
            'order' => 'created_at DESC',
            'limit' => $limit
        ]);
        foreach ($data as &$post) {
            $post['user'] = PURepository::getUserByPostId($post['id']);
            if (!$post['user']) {
                header('HTTP/1.0 404 Not Found');
                exit('User not found for one of the newest posts.');     
            }
        }
        return $data;
    }
    public static function getPaginatedPosts($limit = 10, $offset = 0)
    {
        $data = PostModel::getInstance()->getRecordsAdvanced('*', [], [
            'order' => 'created_at DESC',
            'limit' => $limit,
            'offset' => $offset
        ]);
        foreach ($data as &$post) {
            $post['user'] = PURepository::getUserByPostId($post['id']);
            if (!$post['user']) {
                header('HTTP/1.0 404 Not Found');
                exit('User not found for one of the paginated posts.');     
            }
        }
        return $data;
    }
}