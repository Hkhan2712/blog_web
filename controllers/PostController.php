<?php
class PostController extends MainController
{
    protected $errors = false;
    protected $listPosts;
    protected $record;
    protected $isLiked = false; 
    protected $comments = [];
    public function index()
    {
        $m = PostModel::getInstance();
        $this->listPosts = $m->getListPosts();
        $this->display();
    }

    public function view($id)
    {
        $id = (int)$id[1];
        $pm = PostModel::getInstance();
        $cm = CommentModel::getInstance();
        $this->record = $pm->getPostById($id);
        $this->comments = $cm->getCommentsByPostId($id);
        // Kiểm tra xem user đã like chưa
        $userId = $_SESSION['user']['id'] ?? 0;
        $this->isLiked = false;
        if ($userId) {
            $this->isLiked = $pm->hasUserLiked($id, $userId);
        }

        $this->display(); // views/post/view.php
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
                    'user_id' => (int)$_SESSION['user']['id'] ?? 0,
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