<?php
class PostController extends MainController
{
    public function index()
    {
        
    }

    public function view($id)
    {
        $m = PostModel::getInstance();
        $this->record = $m->getRecord($id, "*", ['joins' => ['user']]);
        $this->display();
    }

    public function add()
    {
        
    }
    public function del($id) {

    }
}