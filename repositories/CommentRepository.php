<?php
class CommentRepository {
    public static function add($postId, $userId, $content, $parentId = 0) {
        $cm = CommentModel::getInstance();

        $commentId = $cm->addRecord([
            'post_id' => $postId,
            'parent_id' => $parentId,
            'user_id' => $userId,
            'content' => $content
        ]);

        if (!$commentId) return false;

        if ($parentId) {
            $parent = $cm->getRecordWhere(['id' => $parentId]);
            $path = $parent && !empty($parent['path']) ? $parent['path'] . "/$commentId" : "$parentId/$commentId";
            $cm->incrementCommentQuantityOfParent($parentId);
        } else {
            $path = "$commentId";
        }

        $cm->updatePath($commentId, $path);
        $cm->incrementCommentQuantity($postId);

        return [
            'id' => $commentId,
            'path' => $path
        ];
    }

    public static function getCommentsWithPagination($postId, $limit = 10, $offset = 0) {
        if (!$postId || !is_numeric($postId)) return [];
        return CommentModel::getInstance()->getCommentsWithPagination($postId, $limit, $offset);
    }

    public static function getRepliesWithPagination($commentId, $limit = 5, $offset = 0) {
        if (!$commentId || !is_numeric($commentId)) return [];
        return CommentModel::getInstance()->getRepliesWithPagination($commentId, $limit, $offset);
    }

    public static function isLiked($commentId, $userId) {
        return CommentModel::checkLiked($commentId, $userId);
    }
}
