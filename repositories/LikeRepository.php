<?php
class LikeRepository {
    public static function checkExist($userId, $entityId, $entityType = 'post') {
        if (!$userId || !$entityId || !in_array($entityType, ['post', 'comment'])) {
            return false;
        }

        $entityType = preg_replace('/[^a-zA-Z0-9_]/', '', $entityType);
        return LikeModel::getInstance()->checkExist($userId, $entityId, $entityType);
    }
    public static function hasLiked($userId, $entityId, $entityType) {
        return LikeModel::getInstance()->checkExist($userId, $entityId, $entityType);
    }

    public static function like($userId, $entityId, $entityType) {
        return LikeModel::getInstance()->add($userId, $entityId, $entityType);
    }

    public static function unlike($userId, $entityId, $entityType) {
        return LikeModel::getInstance()->remove($userId, $entityId, $entityType);
    }

    public static function countLikes($entityId, $entityType) {
        return LikeModel::getInstance()->countLike($entityId, $entityType);
    }
}
