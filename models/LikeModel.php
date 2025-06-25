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

    public function add($userId, $entityId, $entityType = 'post') {
        $existingLike = $this->getRecord(['user_id' => $userId, 'entity_id' => $entityId, 'entity_type' => $entityType]);
        if ($existingLike) {
            return false; 
        }
        return $this->addRecord([
            'user_id' => $userId,
            'entity_id' => $entityId,
            'entity_type' => $entityType
        ]);
    }
    public function remove($userId, $entityId, $entityType = 'post') {
        $existingLike = $this->getRecord(['user_id' => $userId, 'entity_id' => $entityId, 'entity_type' => $entityType]);
        if (!$existingLike) {
            return false; 
        }
        return $this->delRecord($existingLike['id']);
    }

    public function countLike($entityId, $entityType = 'post') {
        $sql = "SELECT COUNT(1) as total FROM $this->table WHERE entity_id = ? AND entity_type = ?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("is", $entityId, $entityType);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return (int)$row['total'];
    }
    public function checkExist($userId, $entityId, $entityType) {
        $userId = (int)$userId;
        $entityId = (int)$entityId;
        $entityType = $this->con->real_escape_string($entityType);

        $sql = "SELECT id FROM likes WHERE user_id = ? AND entity_id = ? AND entity_type = ? LIMIT 1";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("iis", $userId, $entityId, $entityType);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->num_rows > 0;
    }
}