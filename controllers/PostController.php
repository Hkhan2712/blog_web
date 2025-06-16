<?php
class PostController extends MainController
{
    protected $errors = false;
    protected $listPosts;
    protected $record;
    protected $isLiked = false;
    protected $isLikedCm = false; 
    protected $comments = [];
    protected $totalPages = 1;
    protected $currentPage = 1;
    public function index()
    {
        $m = PostModel::getInstance();
        $limit = 10;
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $offset = ($page -1) * $limit;

        $totalPosts = $m->countAllPosts();
        $this->totalPages = ceil($totalPosts / $limit);
        $this->currentPage = $page;
        $this->listPosts = $m->getListPostsPaginate($limit, $offset);
        $this->display();
    }

    public function view($id)
    {
        $id = (int)$id[1];
        $pm = PostModel::getInstance();
        $cm = CommentModel::getInstance();

        $this->record = $pm->getPostById($id);
        $this->comments = $cm->getCommentsByPostId($id);

        if ($this->comments instanceof Traversable) {
            $this->comments = iterator_to_array($this->comments);
        }

        $userId = $_SESSION['user']['id'] ?? 0;

        if ($userId) {
            $this->isLiked = $pm->hasUserLiked($id, $userId);
            foreach ($this->comments as $k => $comment) {
                $comment['is_liked'] = $cm->hasUserLikedCm($comment['id'], $userId);
                $this->comments[$k] = $comment;
            }
        }

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