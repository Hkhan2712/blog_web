<?php 
class CategoryController extends MainController {
    protected $datas;
    protected $totalPages;
    public function show($categoryId) {
        $id = (int)$categoryId[1];
        $this->datas = PCRepository::getCategoryAndPosts($id);
        if (!$this->datas) {
            return;
        }
        $this->display();
    }
}