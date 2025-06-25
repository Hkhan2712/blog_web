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

        $totalPosts = $m->getCountRecords();;
        $this->totalPages = ceil($totalPosts / $limit);
        $this->currentPage = $page;
        $this->listPosts = PostRepository::getPaginatedPosts($limit, $offset);
        $this->display();
    }

    public function view($id)
    {
        $id = (int)$id[1];
        $pm = PostModel::getInstance();
        $this->record['user'] = PURepository::getUserByPostId($id);
        if (!$this->record['user']) {
            header('HTTP/1.0 404 Not Found');
            exit('User not found');
        }   
        $this->record['post'] = $pm->getRecord((int)$id);
        $this->recommendedPosts = PostRepository::getRecommendedPosts($id);
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
                $postModel = PostModel::getInstance();

                $postId = $postModel->addRecord([
                    'title' => $title,
                    'content' => $content,
                    'image_url' => $image ?: 'default.png',
                    'user_id' => (int)($_SESSION['user']['id'] ?? 0),
                ]);

                if (isset($_POST['categories']) && is_array($_POST['categories'])) {
                    $postCategoryModel = PostCategoryModel::getInstance();
                    foreach ($_POST['categories'] as $categoryId) {
                        $postCategoryModel->addPostToCategory($postId,(int)$categoryId);
                    }
                }

                if (!empty($_POST['tags'])) {
                    $tagInput = trim($_POST['tags']);
                    $tagsArray = [];
                    $json = json_decode($tagInput, true);
                    if (is_array($json)) {
                        foreach ($json as $tagItem) {
                            if (!empty($tagItem['value'])) {
                                $tagsArray[] = trim($tagItem['value']);
                            }
                        }
                    }

                    if (!empty($tagsArray)) {
                        $tagModel = TagModel::getInstance();
                        $postTagModel = PostTagModel::getInstance();

                        foreach ($tagsArray as $tagName) {
                            // Kiểm tra xem tag đã tồn tại chưa
                            $tag = $tagModel->getRecordByField('name', $tagName);
                            if (!$tag) {
                                $tagId = $tagModel->addRecord(['name' => $tagName]);
                            } else {
                                $tagId = $tag['id'];
                            }
                            $postTagModel->addTagToPost($postId,$tagId);
                        }
                    }
                }

                header('Location: ' . AppUtil::url(['ctl' => 'post', 'act' => 'view', 'params' => [$postId]]));
                exit();
            } else {
                $this->errors = "Please fill in all required fields.";
            }
        }
        $this->display();
    }

    public function edit($id)
    {
        $id = (int)($id[1] ?? 0);
        $this->record = PostModel::getInstance()->getRecord($id);


        if (!$this->record) {
            header('HTTP/1.0 404 Not Found');
            exit('Post not found');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $content = trim($_POST['content'] ?? '');
            $status = $_POST['status'] ?? 'draft';
            $image = $this->record['image_url'];

            // Xử lý upload ảnh mới nếu có
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image = $this->uploadImg($_FILES, ['folder' => 'posts'], 'image');
            }

            if ($title && $content) {
                // Cập nhật bài viết
                PostModel::getInstance()->updateWhere([
                    'title'     => $title,
                    'content'   => $content,
                    'image_url' => $image,
                    'status'    => $status,
                    'updated_at'=> date('Y-m-d H:i:s')
                ], "id = $id");

                // ===== Categories =====
                $postCategoryModel = PostCategoryModel::getInstance();
                $postCategoryModel->deleteRecordsWhere("post_id = $id");
                if (isset($_POST['categories']) && is_array($_POST['categories'])) {
                    foreach ($_POST['categories'] as $categoryId) {
                        $postCategoryModel->addPostToCategory($id, (int)$categoryId);
                    }
                }

                // ===== Tags =====
                $postTagModel = PostTagModel::getInstance();
                $postTagModel->deleteRecordsWhere("post_id = $id");

                if (!empty($_POST['tags'])) {
                    $tagInput = trim($_POST['tags']);
                    $tagsArray = [];
                    $json = json_decode($tagInput, true);
                    if (is_array($json)) {
                        foreach ($json as $tagItem) {
                            if (!empty($tagItem['value'])) {
                                $tagsArray[] = trim($tagItem['value']);
                            }
                        }
                    }

                    if (!empty($tagsArray)) {
                        $tagModel = TagModel::getInstance();
                        foreach ($tagsArray as $tagName) {
                            $tag = $tagModel->getRecordByField('name', $tagName);
                            if (!$tag) {
                                $tagId = $tagModel->addRecord(['name' => $tagName]);
                            } else {
                                $tagId = $tag['id'];
                            }
                            $postTagModel->addTagToPost($id, $tagId);
                        }
                    }
                }

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
        $record = $m->getRecord($id);

        if (!$record) {
            header('HTTP/1.0 404 Not Found');
            exit('Post not found');
        }

        $m->delRecord($id);
        $postCategoryModel = PostCategoryModel::getInstance();
        $postCategoryModel->deleteRecordsWhere("post_id = $id");
        $postTagModel = PostTagModel::getInstance();
        $postTagModel->deleteRecordsWhere("post_id = $id");
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

        $options = ['folder' => 'posts']; 
        $imagePath = $this->uploadImg($_FILES, $options, 'file');

        if ($imagePath !== false) {
            echo json_encode(['location' => RootURL . UploadREL . $options['folder'] . $imagePath]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Upload failed']);
        }
    }
}