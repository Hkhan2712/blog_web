<?php 
class TagModel extends CrudModel {
    protected $relationships  = [
        'hasMany' => [
            ['post_tag', 'key' => 'post_id']
        ]
    ];
}