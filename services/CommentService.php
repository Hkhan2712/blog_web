<?php
class CommentService {
    public static function createComment($data, $user) {
        $postId = (int)($data['postId'] ?? 0);
        $parentId = (int)($data['parentId'] ?? 0);
        $content = trim($data['content'] ?? '');
        $userId = (int)$user['id'];

        if (!$postId || !$content || !$userId) {
            return [
                'success' => false,
                'code' => 400,
                'message' => 'Invalid post id, user id or missing content'
            ];
        }

        $result = CommentRepository::add($postId, $userId, $content, $parentId);
        if (!$result) {
            return [
                'success' => false,
                'code' => 500,
                'message' => 'Failed to add comment.'
            ];
        }

        return [
            'success' => true,
            'code' => 200,
            'data' => [
                'id' => $result['id'],
                'postId' => $postId,
                'path' => $result['path'],
                'created_at' => date('F d, Y'),
                'author' => htmlspecialchars($user['username'] ?? 'You'),
                'avatar' => !empty($user['avatar_url']) ? $user['avatar_url'] : 'default.png',
                'content' => htmlspecialchars($content),
                'parent_id' => $parentId
            ]
        ];
    }

    public static function fetchComments($data, $userId) {
        $postId = (int)($data['postId'] ?? 0);
        $parentId = isset($data['parentId']) ? (int)$data['parentId'] : null;
        $offset = (int)($data['offset'] ?? 0);
        $limit = (int)($data['limit'] ?? 5);

        if (!$postId && !$parentId) {
            return [
                'success' => false,
                'code' => 400,
                'message' => 'Missing post or parent ID'
            ];
        }

        $comments = $parentId
            ? CommentRepository::getRepliesWithPagination($parentId, $limit, $offset)
            : CommentRepository::getCommentsWithPagination($postId, $limit, $offset);

        foreach ($comments as &$comment) {
            $comment['is_liked'] = CommentRepository::isLiked($comment['id'], $userId);
        }

        return [
            'success' => true,
            'code' => 200,
            'data' => $comments
        ];
    }
}
