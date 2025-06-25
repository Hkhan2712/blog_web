<?php
class LikeRepository {
    public static function checkExist($userId, $entityId, $entityType = 'post') {
        if (!$userId || !$entityId || !in_array($entityType, ['post', 'comment'])) {
            return false;
        }

        $entityType = preg_replace('/[^a-zA-Z0-9_]/', '', $entityType);
        return LikeModel::getInstance()->checkExist($userId, $entityId, $entityType);
    }
}
