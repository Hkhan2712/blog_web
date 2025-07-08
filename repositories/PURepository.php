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
    public static function getUserByPostId($postId, $fields = ['id', 'username', 'email']) {

        $post = PostModel::getInstance()->getRecord($postId);
        if (!$post) return false;

        $safeFields = array_map(function($field) {
            return preg_replace('/[^a-zA-Z0-9_]/', '', $field);
        }, $fields);

        $fieldList = implode(',', $safeFields);
        $user = UserModel::getInstance()->getRecord($post['user_id'], $fieldList);
        if ($user) return $user;
        else return false;
    }
    public static function hasUserLiked($postId, $userId, $entityType = 'post') {
        $postId = (int)$postId;
        $userId = (int)$userId;
        $sql = "SELECT id FROM likes WHERE entity_id = ? AND user_id = ? AND entity_type = ? LIMIT 1";
        $stmt = ConnectDB::getInstance()->getConnection()->prepare($sql);
        $stmt->bind_param("ii", $postId, $userId);
        $stmt->bind_param("s", $entityType);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
}