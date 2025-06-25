<?php 
class CommentRepository {
    public static function getCommentsWithPagination($postId, $limit = 10, $offset = 0) {
        if (!$postId || !is_numeric($postId)) return [];
        return CommentModel::getInstance()->getCommentsWithPagination($postId, $limit, $offset);
    }

    public static function getRepliesWithPagination($commentId, $limit = 5, $offset = 0) {
        if (!$commentId || !is_numeric($commentId)) return [];
        return CommentModel::getInstance()->getRepliesWithPagination($commentId, $limit, $offset);
    }
}