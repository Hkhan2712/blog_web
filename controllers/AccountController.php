<?php 
class AccountController extends MainController {
    protected $posts;
    public function index() {
        AuthMiddleware::check();
        $pm = PostModel::getInstance();
        $userId = isset($_SESSION['user']['id']) ?? 0;
        $this->posts = $pm->getPostsByUserId($userId);
        $this->display();
    }
    public function edit() {
        $this->display();
    }
}