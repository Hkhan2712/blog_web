<?php
class PostController extends MainController
{
    protected $errors = false;
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
        if (isset($_POST['btn_submit'])) {
            $title = trim($_POST['title'] ?? '');
            $content = trim($_POST['content'] ?? '');
            $image = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image = $this->uploadImg($_FILES, ['folder' => 'posts'], 'image');
            } 
            
            if ($title && $content) {
                $m = PostModel::getInstance();
                $m->addRecord([
                    'title' => $title,
                    'content' => $content,
                    'image_url' => $image,
                    'user_id' => $_SESSION['user']['id'] ?? 0,
                ]);
                header('Location:'.AppUtil::url(['ctl' => 'post']));
                exit();
            } else {
                $this->errors = "Please fill in all required fields.";
            }
        }
        $this->display(); // views/post/add.php
    }

    public function del($id) {

    }
}