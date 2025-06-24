<?php 
class TagModel extends CrudModel {
    protected $relationships  = [
        'hasMany' => [
            ['post_tags', 'key' => 'post_id']
        ]
    ];
    protected $table = 'tags';
    public function getRecordByField($field, $value) {
        $sql = "SELECT * FROM {$this->table} WHERE {$field} = ?";
        $stmt = ConnectDB::getInstance()->getConnection()->prepare($sql);
        $stmt->bind_param("s", $value);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}