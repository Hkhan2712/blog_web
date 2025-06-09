<?php
class PostModel extends FrapModel {
    public $nopp = 20;
    public static $status = [
        0 => 'draft',
        1 => 'published',
        2 => 'pending',
        3 => 'archived'
    ];
    protected $relationships = [
        'belongTo' => [
            ['user', 'key' => 'user_id'],
            ['category', 'key' => 'category_id']
        ]
    ];

    public function rules() {
        global $app;
	    return [
        	'title' 		=> [['required', 'errmsg'=>'Title can not bank!'], 'string', ['max', 'value'=>250]],
        	'slug' 		=> [['required', 'errmsg'=>'Slug can not bank!'], 
        					['unique',   'errmsg'=>'This value already existing! Slug should be unique!'], 
        					 'string', ['max', 'value'=>250]],
        	'content' 	=> [['required', 'errmsg'=>'Content can not bank!'], 'string'],
	        'status'	=> [['inlist', 'value'=>array_keys(self::$status)]]
	    ];
    }
}