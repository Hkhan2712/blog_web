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
}