<?php 
class CategoryController extends MainController {
    protected $datas;
    protected $totalPages;
    public function show($categoryId) {
        $this->datas = PCRepository::getCategoryAndPosts($categoryId);
        // var_dump($this->datas); exit;
        if (!$this->datas) {
            return;
        }
        $this->display();
    }
}