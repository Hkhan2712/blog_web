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
        $content = isset($data['content']) ? trim($data['content']) : ''; 
        $userId = $_SESSION['user']['id'] ?? 0;
        if (!$postId || !$content || !$userId) {
            http_response_code(400); 
            echo json_encode(
                ['success' => false, 
                 'message' => 'Invalid post id, user id or missing content', 
                 'json' => [
                    'postId' => $postId,
                    'userId' => $userId,
                    'content' => $content
                 ]
                ]
            );
            return;
        }
        $m = CommentModel::getInstance();
        $result = $m->addComment($userId, $postId, $content);
        if ($result) {
            $authorName = $_SESSION['user']['username'] ?? 'Unknown';
            $avatarUrl = !empty($_SESSION['user']['avatar_url']) 
                ? $_SESSION['user']['avatar_url'] 
                : "avatar-default.png";
            echo json_encode([
                'success' => true,
                'message' => 'Comment added successfully.',
                'data' => [
                    'id' => $result,
                    'author' => htmlspecialchars($authorName),
                    'avatar' => $avatarUrl,
                    'created_at' => date('F d, Y'), 
                    'content' => htmlspecialchars($content),
                ]
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to add comment.']);
        }
    }

    public function reply() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user'])) {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            return;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        $parentId = intval($data['commentId'] ?? 0);
        $postId = intval($data['postId'] ?? 0);
        $content = trim($data['content'] ?? '');

        if (!$parentId || !$postId || !$content) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Missing or invalid data',
                'debug' => compact('parentId', 'postId', 'content')
            ]);
            return;
        }

        $cm = CommentModel::getInstance();
        $commentId = $cm->addRecord([
            'post_id' => $postId,
            'parent_id' => $parentId,
            'user_id' => $_SESSION['user']['id'],
            'content' => $content
        ]);
        if (!$commentId) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to add reply.']);
            return;
        } else {
            $cm->incrementCommentQuantity($postId);
        }

        $parent = $cm->getRecordWhere(['id' => $parentId]);
        if ($parent) {
            $basePath = isset($parent['path']) && $parent['path'] !== ''
                ? $parent['path']
                : $parent['id'];
            $path = $basePath . '/' . $commentId;
        } else {
            $path = (string)$commentId;
        }
        $cm->updatePath($commentId, $path);

        echo json_encode([
            'success' => true,
            'data' => [
                'id' => $commentId,
                'postId' => $postId,
                'path' => $path,
                'created_at' => date('F d, Y'),
                'author' => htmlspecialchars($_SESSION['user']['username'] ?? 'You'),
                'avatar' => !empty($_SESSION['user']['avatar_url'])
                    ? $_SESSION['user']['avatar_url']
                    : "avatar-default.png",
                'content' => htmlspecialchars($content),
            ]
        ]);
    }
    public function loadComment() {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        $postId = intval($data['postId']) ?? 0;
        $offset = intval($data['offset']) ?? 0;
        $limit = intval($data['limit']) ?? 0;

        if (!$postId) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid post id']);
            return;
        }

        $m = CommentModel::getInstance();
        $comments = $m->getCommentsWithPagination($postId, $limit, $offset);

        echo json_encode(['success' => true, 'data' => $comments]);
    }
    public function loadRep() {
        header('Content-Type: application/json');
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
            return;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        $commentId = intval($data['commentId'] ?? 0);
        $offset = intval($data['offset'] ?? 0);
        $limit = intval($data['limit'] ?? 5);

        if (!$commentId) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Missing commentId']);
            return;
        }

        $cm = CommentModel::getInstance();
        $replies = $cm->getRepliesWithPagination($commentId, $limit, $offset);

        echo json_encode(['success' => true, 'data' => $replies]);
    }
}
