<?php
class LikeController extends MainController
{
    public function like() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); 
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
            return;
        }
        $userId = $_SESSION['user']['id'] ?? 0;
        $data = json_decode(file_get_contents("php://input"), true);
        $entityId = isset($data['id']) ? (int)$data['id'] : 0;
        $entityType = isset($data['type']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $data['type']) : 'post';
        if (!$entityId || !$userId || !in_array($entityType, ['post', 'comment'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid data', 'data' => $data]);
            return;
        }

        $m = LikeModel::getInstance();
        $result = $m->add($userId, $entityId, $entityType);
        if ($result) {
            $totalLikes = $m->countLike($entityId, $entityType);

            if ($entityType === 'post') {
                $entityModel = PostModel::getInstance();
            } else {
                $entityModel = CommentModel::getInstance();
            }

            $entityModel->editRecord(['id' => $entityId], ['like_quantity' => $totalLikes]);

            echo json_encode(['success' => true, 'like_quantity' => $totalLikes]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to like the entity or already liked.']);
        }
    }

    public function unlike()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
            return;
        }
        $userId = $_SESSION['user']['id'] ?? 0;
        $data = json_decode(file_get_contents("php://input"), true);
        $entityId = isset($data['id']) ? (int)$data['id'] : 0;
        $entityType = isset($data['type']) ? preg_replace('/[^a-zA-Z0-9_]/', '', $data['type']) : 'post';
        if (!$entityId || !$userId || !in_array($entityType, ['post', 'comment'])) {
            echo json_encode(['success' => false, 'message' => 'Invalid data.', 'data' => $data]);
            return;
        }

        $likeModel = LikeModel::getInstance();
        $result = $likeModel->remove($userId, $entityId, $entityType);

        if ($result) {
            $totalLikes = $likeModel->countLike($entityId, $entityType);

            if ($entityType === 'post') {
                $entityModel = PostModel::getInstance();
            } else {
                $entityModel = CommentModel::getInstance();
            }

            $entityModel->editRecord(['id' => $entityId], ['like_quantity' => $totalLikes]);

            echo json_encode(['success' => true, 'like_quantity' => $totalLikes]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to unlike or not liked before.']);
        }
    }
}
