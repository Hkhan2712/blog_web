<?php 
class PURepository {
    public static function getPostsByUserId($userId) {
        $sql = "
            SELECT 
                u.id as user_id,
                u.username,
                u.display_name,
                u.email,
                u.avatar_url,
                p.id as post_id,
                p.title,
                p.slug,
                p.content,
                p.image_url,
                p.like_quantity,
                p.comment_quantity,
                p.created_at,
                p.status
            FROM users u
            LEFT JOIN posts p ON p.user_id = u.id
            WHERE u.id = " . intval($userId);

        $result = ConnectDB::getInstance()->getConnection()->query($sql);
        $data = [];
        $posts = [];

        while ($row = mysqli_fetch_assoc($result)) {
            if (!isset($data['user'])) {
                $data['user'] = [
                    'id' => $row['user_id'],
                    'username' => $row['username'],
                    'display_name' => $row['display_name'],
                    'email' => $row['email'],
                    'avatar_url' => $row['avatar_url']
                ];
            }

            if (!is_null($row['post_id'])) {
                $posts[] = [
                    'id' => $row['post_id'],
                    'title' => $row['title'],
                    'slug' => $row['slug'],
                    'content' => $row['content'],
                    'image_url' => $row['image_url'],
                    'like_quantity' => $row['like_quantity'],
                    'comment_quantity' => $row['comment_quantity'],
                    'created_at' => $row['created_at'],
                    'status' => $row['status']
                ];
            }
        }
        $data['posts'] = $posts;
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
        $conn = ConnectDB::getInstance()->getConnection();
        
        $sql = "SELECT id FROM likes WHERE entity_id = ? AND user_id = ? AND entity_type = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        if (!$stmt) return false;

        $stmt->bind_param("iis", $postId, $userId, $entityType);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }

}