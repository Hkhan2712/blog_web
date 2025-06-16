<?php 
class CommentController extends MainController {
    public function add() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); 
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
            return;
        }
        $data = json_decode(file_get_contents("php://input"), true);
        $postId = isset($data['postId']) ? (int)$data['postId'] : 0;
        $content = isset($data['comment']) ? trim($data['comment']) : ''; 
        $userId = $_SESSION['user']['id'] ?? 0;
        if (!$postId || !$content || !$userId) {
            http_response_code(400); 
            echo json_encode(['success' => false, 'message' => 'Invalid post ID, comment or user ID.']);
            return;
        }
        $m = CommentModel::getInstance();
        $result = $m->addComment($userId, $postId, $content);
        if ($result) {
            $authorName = $_SESSION['user']['username'] ?? 'Unknown';
            $avatarUrl = !empty($_SESSION['user']['avatar_url']) 
                ? RootREL . "media/uploads/users/" . $_SESSION['user']['avatar_url'] 
                : RootREL . "media/uploads/users/avatar-default.png";
            echo json_encode([
                'success' => true,
                'message' => 'Comment added successfully.',
                'comment' => [
                    'author_name' => htmlspecialchars($authorName),
                    'avatar_url' => $avatarUrl,
                    'created_at' => date('F d, Y'), 
                    'content' => htmlspecialchars($content),
                ]
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to add comment.']);
        }
    }
}
