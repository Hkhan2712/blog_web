<?php
class PaginationModel extends FrapModel {

	public function read_paging($model, $filed_oder_by = 'created') {
		global $app;
		$ctl = $app['ctl'];
		$act = $app['act'];
		// home page url
		$home_url=RootURL;
		// page given in URL parameter, default page is one
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		 
		// set number of records per page
		$records_per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 5;
		 
		// calculate for the query LIMIT clause
		$from_record_num = ($records_per_page * $page) - $records_per_page;
		$stmt = $model->readPaging($from_record_num, $records_per_page, $filed_oder_by);
		$num = count($stmt);
		 
		// check if more than 0 record found
		if($num>0){
		 
		    // products array
		    $products_arr=array();
		    $products_arr["records"]=array();
		    $products_arr["paging"]=array();
		    
			$products_arr["records"] = array_merge($products_arr["records"], $stmt);
		    $total_rows=$this->rowCount();
		    $page_url="{$home_url}api/{$ctl}/{$act}?";
		    $paging=$this->getPaging($page, $total_rows, $records_per_page, $page_url);
		    $products_arr["paging"]=$paging;
		 
		    // set response code - 200 OK
		    http_response_code(200);
		 
		    // make it json format
		    echo json_encode($products_arr);
		}
		 
		else{
		 
		    // set response code - 404 Not found
		    http_response_code(404);
		 
		    // tell the user products does not exist
		    echo json_encode(
		        array("message" => "Không tìm thấy dữ liệu!")
		    );
		}
	}

	public function read_pagingFollowId($model, $filed_oder_by = 'created', $params=[]) {
		global $app;
		$ctl = $app['ctl'];
		$act = $app['act'];
		// home page url
		$home_url=RootURL;
		// page given in URL parameter, default page is one
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		 
		// set number of records per page
		$records_per_page = isset($_GET['per_page']) ? $_GET['per_page'] : 5;
		
		// calculate for the query LIMIT clause
		$from_record_num = ($records_per_page * $page) - $records_per_page;

		$categoryId = $params['categoryId'];

		$stmt = $model->list_job_category($from_record_num, $records_per_page, $filed_oder_by,$categoryId);
		
		$save_model = new save_model();
		$apply_model = new application_model();

		if(isset($app['user_auth']['id'])){
			foreach ($stmt as $key => $value) {
				$stmt[$key]['isSaved'] = $save_model->checkSaved($app['user_auth']['id'],$stmt[$key]['id']);
			}
			foreach ($stmt as $key => $value) {
				$stmt[$key]['isApply'] = $apply_model->checkApply($app['user_auth']['id'],$stmt[$key]['id']);
			}
		}else{
			foreach ($stmt as $key => $value) {
				$stmt[$key]['isSaved'] = 0;
			}
			foreach ($stmt as $key => $value) {
				$stmt[$key]['isApply'] = 0;
			}
		}
			
		$num = count($stmt);
		 
		// check if more than 0 record found
		if($num>0){
		 
		    // products array
		    $products_arr=array();
		    $products_arr["records"]=array();
		    $products_arr["paging"]=array();
	 
	        $products_arr["records"] = array_merge($products_arr["records"], $stmt);

		    $total_rows=$this->rowCountWhere("categories_arr LIKE '%,{$categoryId},%'");
		    if(count($params)){

		    	$link = "";
		    	$i = 0;
		    	foreach ($params as $key => $value) {
		    		if($i == 0) $link .= $key.'='.$value;
		    		else $link .= '&'.$key.'='.$value;
		    	}
		    	$page_url="{$home_url}api/{$ctl}/{$act}?{$link}&";

		    }else{
		    	$page_url="{$home_url}api/{$ctl}/{$act}?";

		    }
		    $paging=$this->getPaging($page, $total_rows, $records_per_page, $page_url);
		    $products_arr["paging"]=$paging;
		 
		    // set response code - 200 OK
		    http_response_code(200);
		 
		    // make it json format
		    echo json_encode($products_arr);
		}
		 
		else{
		 
		    // set response code - 404 Not found
		    http_response_code(404);
		 
		    // tell the user products does not exist
		    echo json_encode(
		        array("message" => "Không tìm thấy dữ liệu!")
		    );
		}
	}

	public function rowCount()
	{
		$sql = "SELECT COUNT(*) as total_rows FROM " . $this->table;
	    $result = $this->con->query($sql);
		if($result) {
			$record = $result->fetch_assoc();
		} else $record=false;
	 
	    return $record['total_rows'];
	}
	public function rowCountWhere($conditions=null)
	{
		if($conditions) $conditions = " WHERE {$conditions}";
		$sql = "SELECT COUNT(*) as total_rows FROM " . $this->table ." {$conditions}" ;
		
	    $result = $this->con->query($sql);
		if($result) {
			$record = $result->fetch_assoc();
		} else $record=false;
	 
	    return $record['total_rows'];
	}

	public function getPaging($page, $total_rows, $records_per_page, $page_url){
 
        // paging array
        $paging_arr=array();
 
        // button for first page
        $paging_arr["first"] = $page>1 ? "{$page_url}page=1&per_page={$records_per_page}" : "";
 
        // count all products in the database to calculate total pages
        $total_pages = ceil($total_rows / $records_per_page);
 
        // range of links to show
        $range = 2;
 
        // display links to 'range of pages' around 'current page'
        $initial_num = $page - $range;
        $condition_limit_num = ($page + $range)  + 1;
 
        $paging_arr['pages']=array();
        $page_count=0;
         
        for($x=$initial_num; $x<$condition_limit_num; $x++){
            // be sure '$x is greater than 0' AND 'less than or equal to the $total_pages'
            if(($x > 0) && ($x <= $total_pages)){
                $paging_arr['pages'][$page_count]["page"]=$x;
                $paging_arr['pages'][$page_count]["url"]="{$page_url}page={$x}&per_page={$records_per_page}";
                $paging_arr['pages'][$page_count]["current_page"] = $x==$page ? "yes" : "no";
 
                $page_count++;
            }
        }
 
        // button for last page
        $paging_arr["last"] = $page<$total_pages ? "{$page_url}page={$total_pages}&per_page={$records_per_page}" : "";
 
        // json format
        return $paging_arr;
    }

	// public function readPaging($from_record_num, $records_per_page, $filed_oder_by = 'created')
	// {
	// 	// select query
	//     $sql = "SELECT * FROM $this->table p 
	//     	ORDER BY p.{$filed_oder_by} 
	//     	DESC LIMIT " .$from_record_num. "," .$records_per_page;
	//     $result = $this->con->query($sql);
	// 	$rows = array();
	// 	while($row = mysqli_fetch_assoc($result)) {
	// 		$rows[] = $row;
	// 	}
	// 	return $rows;
	// }
}?>