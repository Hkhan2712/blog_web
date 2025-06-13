<?php 
class LikeController extends MainController
{
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Đọc JSON từ body request
            $data = json_decode(file_get_contents("php://input"), true);
            $postId = isset($data['postId']) ? (int)$data['postId'] : 0;
            $userId = $_SESSION['user']['id'] ?? 0;

            if ($postId && $userId) {
                $m = LikeModel::getInstance();
                $result = $m->likePost($userId, $postId);
                
                if ($result) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to like the post.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid post or user ID.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
        }
    }
}
