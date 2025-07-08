<?php
class LikeController extends MainController
{
    public function toggle() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            exit();
        }

        $userId = $_SESSION['user']['id'] ?? 0;
        $data = json_decode(file_get_contents("php://input"), true);
        $entityId = (int)($data['id'] ?? 0);
        $entityType = preg_replace('/[^a-zA-Z0-9_]/', '', $data['type'] ?? 'post');

        if (!$userId || !$entityId || !in_array($entityType, ['post', 'comment'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid data']);
            exit();
        }

        $result = LikeService::toggleLike($userId, $entityId, $entityType);

        echo json_encode([
            'success' => true,
            'liked' => $result['liked'],
            'like_quantity' => $result['like_quantity']
        ]);
        exit();
    }
}
