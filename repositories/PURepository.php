<?php 
class PURepository {
    public static function getPostsByUserId($userId) {
        $data = [];
        $user = UserModel::getInstance()->getRecord($userId);
        if ($user) {
            $data['user'] = $user;
            $posts = PostModel::getInstance()->getRecords('*', ['conditions' => 'user_id = '. $data['user']['id']]);
            $postData = [];
            while ($row = mysqli_fetch_array($posts)) {
                $postData[] = $row;
            }

            if (count($postData)) {
                $data['posts'] = $postData;
            } else $data['posts'] = [];
        } else $data = false;
        return $data;
    }
    public static function getUserByPostId($postId) {

    }
}