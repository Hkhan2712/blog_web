<?php
class PostController extends MainController
{
    protected $listPosts;
    protected $record;
    public function index()
    {
        $m = PostModel::getInstance();
        $this->listPosts = $m->getListPosts(10);
        $this->display();
    }

    public function view($id)
    {
        $id = (int)$id[1];
        $m = PostModel::getInstance();
        $this->record = $m->getPostById($id);
        $this->display();
    }
    
    public function add()
    {
        
    }
    public function del($id) {

    }
}