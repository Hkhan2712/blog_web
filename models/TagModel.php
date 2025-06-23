<?php 
class TagModel extends CrudModel {
    protected $relationships  = [
        'hasMany' => [
            ['post_tags', 'key' => 'post_id']
        ]
    ];
}