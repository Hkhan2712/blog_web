<?php 
class CrudModel extends MainModel {
    use Validator;

    public function delRecord($id = null, $conditions = null) {

    } 

    public function delRelativeRecord($id = null, $conditions = null) {

    }

    public function delRelativeRecordWhere($id = null, $conditions = null) {

    }

    public function delRRAD($ids = null, $conditions = null) {

    }

    public function delRecords($ids = null, $conditions = null) {

    }

    public function delRelativeRecords($ids = null, $conditions = null) {

    }

    public function delRelativeRecordsWhere($ids = null, $conditions = null) {

    }

    public function delRsRAD($id = null, $conditions = null) {

    }
    
    public function addRecord($datas) {

    }

    public function editRecord($id, $datas, $conditions = null) {
        global $app;
        if (is_array($id)) {
            $id = array_key_exists('id', $id) ? $id['id'] : $id[1];
        }    
        $setDatas = '';
        $i = 0;
        foreach ($datas as $k => $v) {
            if (is_string($v)) {
                $v = mysqli_real_escape_string($this->con, $v);
            }
            if ($i) {
                $setDatas .= ',';
            }
            $setDatas .= $k. "='".$v."'";
            $i++;
        }
        if ($updatedTime = $this->recordTime($app['recordTime']['updatedTime'])) {
            $setDatas .= ','.$app['recordTime']['updatedTime'].'='.$updatedTime;
        }
        if ($conditions) $conditions = ' and '.$conditions;
        $query = "UPDATE $this->table SET $setDatas where id ='$id'".$conditions;

        if (mysqli_query($this->con, $query)) 
            return true;
        else {
            $this->errors['type'] = 'database';
            $this->errors['message'] = mysqli_error($this->con);
            return false;
        }
    }

    public function editRecords($ids, $datas, $conditions = null) {

    }

    public function editRecordsWhere($data, $conditions = "") {

    }

    public function deleteRecordsWhere($conditions = "") {

    }

    public function recordTime($field) {

    }

    public function getColumnsName() {

    }

    public function validator($data, $editId = false) {
        
    }
}