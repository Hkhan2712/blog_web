<?php 
class CategoryModel extends FrapModel {
    public $nopp = 10;
    public function rules() {
        global $app;
	    return [
        	'name' 		=> [['required', 'errmsg'=>'Name can not bank!'], 'string', ['max', 'value'=>250]],
        	'slug' 		=> [['required', 'errmsg'=>'Slug can not bank!'], 
        					['unique',   'errmsg'=>'This value already existing! Slug should be unique!'], 
        					 'string', ['max', 'value'=>250]],
        	'description'=>[['required', 'errmsg'=>'Description can not bank!'], 'string'],
	    ];
    }
	public function getCategoriesActive($limit = 0) {
		$sql = "SELECT * FROM `categories` WHERE `status` = 'active' ORDER BY `created_at` DESC";
		if ($limit > 0) {
			$sql .= " LIMIT " . (int)$limit;
		}

		$result = $this->con->query($sql);
		$data = [];
		while ($row = $result->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}
}