<?php
class CommentController extends MainController {
    public function store() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        $response = CommentService::createComment($data, $_SESSION['user']);
        http_response_code($response['code']);
        echo json_encode($response);
    }

    public function load() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        $response = CommentService::fetchComments($data, $_SESSION['user']['id'] ?? 0);
        http_response_code($response['code']);
        echo json_encode($response);
    }
}