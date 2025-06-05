<?php 
class CrudModel extends MainModel {
    use Validator;

    public function delRecord($id = null, $conditions = null) {
        if (is_array($id)) {
            $id = array_key_exists('id', $id) ? $id['id'] : $id[1];
        }
        if ($conditions && $id != null) $conditions = ' AND '.$conditions;
        $id = HtmlHelper::processSQLString($id);

        if ($id == null) 
            $sql = "DELETE FROM $this->table WHERE ".$conditions;
        else 
            $sql = "DELETE FROM $this->table where id=$id".$conditions;
        return $this->con->query($sql);
    } 

    public function delRelativeRecord($id = null, $conditions = null) {
        if($conditions)	$conditions = ' and '.$conditions;
		$tables = $this->table;
		$innerJoin = "";

		if(isset($this->relationships) && isset($this->relationships['hasMany'])) {
			$hasManyArr = (AppUtil::isMultiArray($this->relationships['hasMany']))?
							$this->relationships['hasMany'] : [$this->relationships['hasMany']];
			foreach($hasManyArr as $v) {
				if($v['on_del']) {
					$joinTable = NounUtils::pluralize($v[0]);
					$tables .= ",".$joinTable;
					$innerJoin .= " LEFT JOIN ".$joinTable." ON ".$this->table.".id=".$joinTable.".".$v['key'];
				}
			}
		}
		$id = HtmlHelper::processSQLString($id);
		$sql = "DELETE ".$tables." FROM ".$this->table.$innerJoin." WHERE $this->table.id=$id".$conditions;
		return $this->con->query($sql);
    }

    public function delRelativeRecordWhere($id = null, $conditions = null) {
        if($conditions)	$conditions = ' and '.$conditions;
		$tables = $this->table;
		$wheres = "";

		if(isset($this->relationships) && isset($this->relationships['hasMany'])) {
			$hasManyArr = (AppUtil::isMultiArray($this->relationships['hasMany']))?
							$this->relationships['hasMany'] : [$this->relationships['hasMany']];
			foreach($hasManyArr as $v) {
				if($v['on_del']) {
					$joinTable = NounUtils::pluralize($v[0]);
					$tables .= ",".$joinTable;
					$wheres .= " AND ".$this->table.".id=".$joinTable.".".$v['key'];
				}
			}
		}
		$id = HtmlHelper::processSQLString($id);
		$sql = "DELETE ".$tables." FROM ".$tables." WHERE id=$id".$wheres.$conditions;
		return $this->con->query($sql);
    }

    public function delRRAD($id = null, $conditions = null) {
        if ($conditions) $condition = ' and '.$conditions;
        $id = HtmlHelper::processSQLString($id);
        $sql = "DELETE FROM $this->table WHERE id = $id ".$conditions;
        if ($this->con->qeury($id)) {
            if (isset($this->relationships) && isset($this->relationships['hasMany'])) {
                $hasManyArr = (AppUtil::isMultiArray($this->relationships['hasMany'])) ?
                                $this->relationships['hasMany'] : [$this->relationships['hasMany']];
                foreach ($hasManyArr as $v) {
                    if ($v['on_del']) {
                        $joinTable = NounUtils::pluralize($v[0]);
                        $joinModel = new $v[0]();
                        $joinRecords = $joinModel->getRecords($id, ['conditions' => $joinTable.'.'.$this->table.'_id = '.$id]);
                        while ($record = mysqli_fetch_array($joinRecords)) {
                            $joinModel->delRRAD($record['id']);
                        }
                    }
                }
            }
            return true;
        } else 
            return false;
    }

    public function delRecords($ids = null, $conditions = null) {
        if ($conditions) $conditions = ' AND '.$conditions;
        $ids = HtmlHelper::processSQLString($ids);
        $sql = "DELETE FROM $this->table where id in ($ids) $conditions";
        return $this->con->query($sql);
    }

    public function delRelativeRecords($ids = null, $conditions = null) {
        if($conditions)	$conditions = ' and '.$conditions;
		$tables = $this->table;
		$innerJoin = "";

		if(isset($this->relationships) && isset($this->relationships['hasMany'])) {
			$hasManyArr = (AppUtil::isMultiArray($this->relationships['hasMany']))?
							$this->relationships['hasMany'] : [$this->relationships['hasMany']];
			foreach($hasManyArr as $v) {
				if($v['on_del']) {
					$joinTable = NounUtils::pluralize($v[0]);
					$tables .= ",".$joinTable;
					$innerJoin .= " LEFT JOIN ".$v[0]." ON ".$this->table.".id=".$joinTable.".".$v['key'];
				}
			}
		}
		$sql = "DELETE ".$tables." FROM ".$this->table.$innerJoin." WHERE $this->table.id in ($ids) $conditions";
		return $this->con->query($sql);
    }

    public function delRelativeRecordsWhere($ids = null, $conditions = null) {
        if($conditions)	$conditions = ' and '.$conditions;
		$tables = $this->table;
		$wheres = "";

		if(isset($this->relationships) && isset($this->relationships['hasMany'])) {
			$hasManyArr = (AppUtil::isMultiArray($this->relationships['hasMany']))?
							$this->relationships['hasMany'] : [$this->relationships['hasMany']];
			foreach($hasManyArr as $v) {
				if($v['on_del']) {
					$joinTable = NounUtils::pluralize($v[0]);
					$tables .= ",".$joinTable;
					$wheres .= " AND ".$this->table.".id=".$joinTable.".".$v['key'];
				}
			}
		}
		$ids = HtmlHelper::processSQLString($ids);
		$sql = "DELETE ".$tables." FROM ".$tables." WHERE id in ($ids) $wheres $conditions";
		return $this->con->query($sql);
    }

    public function delRsRAD($id = null, $conditions = null) {
        if ($conditions) $conditions = ' AND '.$conditions;
        $ids = HtmlHelper::processSQLString($ids);
        $sql = "DELETE FROM $this->table WHERE id in ($ids) $conditions";
        if ($this->con->query($sql)) {
            if (isset($this->relationships) && isset($this->relationships['hasMany'])) {
                $hasManyArr = AppUtil::isMultiArray($this->relationships['hasMany']) ?
                                $this->relationships['hasMany'] : [$this->relationships['hasMany']];
                foreach ($hasManyArr as $v) {
                    if ($v['on_del']) {
                        $joinTable = NounUtils::pluralize($v[0]);
                        $joinModel = new $v[0]();
                        $joinRecords = $joinModel->getRecords('id', ['conditions' => $joinTable.'.'.$this->table.'_id = in ('.$ids.')' ]);
                        while ($record = mysqli_fetch_array($joinRecords)) {
                            $joinModel->delRRAD($record['id']);
                        }
                    }
                }
            }
            return true;
        } else 
            return false;
    }
    
    public function addRecord($datas) {
        global $app;
        $fields = $values = '';
        $i = 0;
        foreach ($datas as $k => $v) {
            if (is_string($v)) {
                $v = mysqli_real_escape_string($this->con, $v);
            }

            if ($i) {
                $fields .= ',';
                $values .= ',';
            }
            $fields .= $k;
            $values .= "'".$v.".";
            $i++;
        }
        
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