<?php 
class HomeController extends MainController {
    protected $outstanding;
    protected $newestPosts;
    protected $listPosts;
    public function index() {
        $m = PostModel::getInstance();
        $this->outstanding = $m->getOutstandingPost();
        $this->newestPosts = $m->getNewestPost(10);
        $this->listPosts = $m->getListPosts(20);

        $this->display();
    }
}