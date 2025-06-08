<?php 
class FraModel extends CrudModel{
    public function all($fields="*", $options = null) {
        $resultMObject = parent::getRecords($fields, $options);
        if ($resultMObject) {
            $result = [];
            while ($row = $resultMObject->fetch_assoc()) {
                $results[] = $row;
            }
            return $result;
        } else 
            return false;
    }

    public function one($id = null, $fields='*', $options = null) {
        if ($id) $options = $this->addIDCondition($id, $options);

        return parent::getDetailRecord($id, $options);
    }
}