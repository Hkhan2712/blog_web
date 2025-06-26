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
        $postId = (int)($data['postId'] ?? 0);
        $parentId = (int)($data['parentId'] ?? 0);
        $content = trim($data['content'] ?? '');
        $userId = (int)$_SESSION['user']['id'];

        if (!$postId || !$content || !$userId) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Invalid post id, user id or missing content']);
            return;
        }
        $cm = CommentModel::getInstance();
        $commentId = $cm->addRecord([
            'post_id' => $postId,
            'parent_id' => $parentId,
            'user_id' => $userId,
            'content' => $content
        ]);
        if (!$commentId) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to add comment.']);
            return;
        }

        if ($parentId) {
            $parent = $cm->getRecordWhere(['id' => $parentId]);
            $path = $parent && !empty($parent['path']) ? $parent['path'] . "/$commentId" : "$parentId/$commentId";
            $cm->incrementCommentQuantityOfParent($parentId);
        } else {
            $path = "$commentId";
        }
        $cm->updatePath($commentId, $path);
        $cm->incrementCommentQuantity($postId);
        echo json_encode(
            [
                'success' => true,
                'message' => 'Comment added successfully.',
                'data' => [
                    'id' => $commentId,
                    'postId' => $postId,
                    'path' => $path,
                    'created_at' => date('F d, Y'),
                    'author' => htmlspecialchars($_SESSION['user']['username'] ?? 'You'),
                    'avatar' => !empty($_SESSION['user']['avatar_url'])
                        ? $_SESSION['user']['avatar_url']
                        : "default.png",
                    'content' => htmlspecialchars($content),
                    'parent_id' => $parentId
                ]
            ]
        );

    }

    public function load() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        $data = json_decode(file_get_contents("php://input"), true);
        $postId = (int)($data['postId'] ?? 0);
        $parentId = isset($data['parentId']) ? (int)$data['parentId'] : null;
        $offset = (int)($data['offset'] ?? 0);
        $limit = (int)($data['limit'] ?? 5);
        $cm = CommentModel::getInstance();
        if ($parentId) {
            $comments = $cm->getRepliesWithPagination($parentId, $limit, $offset);
        } else {
            if (!$postId) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => 'Missing post ID']);
                return;
            }
            $comments = $cm->getCommentsWithPagination($postId, $limit, $offset);
        }
        foreach ($comments as &$comment) {
            $comment['is_liked'] = CommentModel::checkLiked($comment['id'], $_SESSION['user']['id'] ?? 0);  
        }
        
        echo json_encode([
            'success' => true,
            'data' => $comments
        ]);
    }
}
