<?php

use Dom\Comment;

class LikeController extends MainController
{
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents("php://input"), true);
            $postId = isset($data['postId']) ? (int)$data['postId'] : 0;
            $userId = (int)$_SESSION['user']['id'] ?? 0;
            if ($postId && $userId) {
                $m = LikeModel::getInstance();
                $result = $m->like($userId, $postId, 'post');

                if ($result) {
                    $totalLikes = $m->countLikesForPost($postId);

                    $postModel = PostModel::getInstance();
                    $postModel->editRecord(['id' => $postId], ['like_quantity' => $totalLikes]);

                    header('Content-Type: application/json');
                    http_response_code(200);
                    echo json_encode(['success' => true, 'like_quantity' => $totalLikes]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to like the post or already liked.']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid post or user ID.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
        }
    }

    public function addLikeCm()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); 
            echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
            return;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        $commentId = isset($data['commentId']) ? (int)$data['commentId'] : 0;
        $userId = (int)($_SESSION['user']['id'] ?? 0);
        if (!$commentId || !$userId) {
            echo json_encode(['success' => false, 'message' => 'Invalid comment or user ID.']);
            return;
        }

        $m = LikeModel::getInstance();
        $result = $m->like($userId, $commentId, 'comment');

        if ($result) {
            $totalLikes = $m->countLikesForComment($commentId);

            $cmModel = CommentModel::getInstance();
            $cmModel->editRecord(['id' => $commentId], ['like_quantity' => $totalLikes]);

            echo json_encode(['success' => true, 'like_quantity' => $totalLikes]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to like the comment or already liked.']);
        }
    }
}
