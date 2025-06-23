<?php
class PostController extends MainController
{
    protected $errors = false;
    protected $listPosts;
    protected $record;
    protected $keyword; 
    protected $totalPages = 1;
    protected $currentPage = 1;
    protected $recommendedPosts = [];
    public function index()
    {
        $m = PostModel::getInstance();
        $limit = 12;
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
        $this->recommendedPosts = $pm->getRecommendedPosts($id);

        $userId = $_SESSION['user']['id'] ?? 0;
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
        $this->display(); 
    }
    public function edit($id)
    {
        $id = (int)$id[1];
        $m = PostModel::getInstance();
        $this->record = $m->getPostById($id);

        if (!$this->record) {
            header('HTTP/1.0 404 Not Found');
            exit('Post not found');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $tags = trim($_POST['tags'] ?? '');
            $content = trim($_POST['content'] ?? '');
            $image = $this->record['image_url'];

            // Xử lý upload ảnh mới nếu có
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image = $this->uploadImg($_FILES, ['folder' => 'posts'], 'image');
            }

            // Validate
            if ($title && $content) {
                $m->updateWhere([
                    'title'     => $title,
                    'content'   => $content,
                    'image_url' => $image,
                ], "id = $id");
                header('Location: ' . AppUtil::url(['ctl' => 'post', 'act' => 'view', 'params' => [$id]]));
                exit();
            } else {
                $this->errors = "Please fill in all required fields.";
            }
        }

        $this->display();
    }
    public function del($id) {
        $id = (int)$id[1];
        $m = PostModel::getInstance();
        $record = $m->getPostById($id);

        if (!$record) {
            header('HTTP/1.0 404 Not Found');
            exit('Post not found');
        }

        $m->delRecord($id);
        header('Location:' . AppUtil::url(['ctl' => 'post']));
        exit();
    }
    public function search() {
        $keyword = trim($_GET['keyword'] ?? '');
        $m = PostModel::getInstance();

        if (empty($keyword)) {
            header('Location:' . AppUtil::url(['ctl' => 'post']));
            exit();
        }

        $limit = 10;
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $offset = ($page - 1) * $limit;

        $this->listPosts = $m->search(['title','content'], $keyword, $limit, $offset);
        $totalResults = $m->countSearch(['title', 'content'],$keyword);
        $this->totalPages = ceil($totalResults / $limit);
        $this->currentPage = $page;
        $this->keyword = $keyword;

        $this->display();
    }
    public function uploadTinyMce() {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['file'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid request']);
            return;
        }

        $options = ['folder' => 'posts']; // bạn muốn lưu ảnh vào thư mục nào
        $imagePath = $this->uploadImg($_FILES, $options, 'file');

        if ($imagePath !== false) {
            echo json_encode(['location' => RootURL . UploadREL . $options['folder'] . $imagePath]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Upload failed']);
        }
    }
}