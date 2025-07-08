<?php
class LikeService {
    public static function toggleLike($userId, $entityId, $entityType) {
        $alreadyLiked = LikeRepository::hasLiked($userId, $entityId, $entityType);

        if ($alreadyLiked) {
            LikeRepository::unlike($userId, $entityId, $entityType);
        } else {
            LikeRepository::like($userId, $entityId, $entityType);
        }

        $count = LikeRepository::countLikes($entityId, $entityType);
        self::updateLikeCount($entityId, $entityType, $count);

        return [
            'liked' => !$alreadyLiked,
            'like_quantity' => $count,
        ];
    }

    private static function updateLikeCount($entityId, $entityType, $count) {
        $model = $entityType === 'post' ? PostModel::getInstance() : CommentModel::getInstance();
        $model->editRecord(['id' => $entityId], ['like_quantity' => $count]);
    }
}
