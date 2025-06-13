<?php 
class LikeModel extends CrudModel {
    protected $table = 'likes';
    protected $primaryKey = 'id';
    
    protected $relationships = [
        'belongTo' => [
            ['user', 'key' => 'user_id'],
            ['post', 'key' => 'post_id']
        ]
    ];

    public function rules() {
        return [
            'user_id' => [['required', 'errmsg' => 'User ID is required'], 'integer'],
            'entity_id' => [['required', 'errmsg' => 'Entity ID is required'], 'integer']
        ];
    }

    public function likePost($userId, $entityId, $entityType = 'post') {
        // Check if the user has already liked the post
        $existingLike = $this->getRecord(['user_id' => $userId, 'entity_id' => $entityId, 'entity_type' => $entityType]);
        if ($existingLike) {
            return false; // User has already liked this post
        }

        // Insert new like
        return $this->addRecord([
            'user_id' => $userId,
            'entity_id' => $entityId,
            'entity_type' => $entityType
        ]);
    }
}