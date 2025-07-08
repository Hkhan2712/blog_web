<?php
class PostController extends MainController
{
    public function index() {
        $page = $_GET['page'] ?? 1;
        $result = PostRepository::getPostListWithPagination($page, 12);

        $this->display(null, [
            'listPosts'    => $result['posts'],
            'totalPages'   => $result['totalPages'],
            'currentPage'  => $result['currentPage'],
        ]);
    }

    public function view($id)
    {
        $id = is_array($id) && isset($id[1]) ? (int)$id[1] : (int)$id;

        $record = PostRepository::view($id);
        if (!$record) {
            header('HTTP/1.0 404 Not Found');
            exit('Post or user not found');
        }

        $recommended = PostRepository::getRecommendedPosts($id);

        $this->display(null, [
            'record' => $record,
            'recommendedPosts' => $recommended
        ]);
    }

    public function add() {
        $errors = false;

        if (isset($_POST['btn_submit'])) {
            $postId = PostRepository::save($_POST, $_FILES);
            if ($postId) {
                header('Location: ' . AppUtil::url(['ctl' => 'post', 'act' => 'view', 'params' => [$postId]]));
                exit();
            } else {
                $errors = "Please fill in all required fields.";
            }
        }

        $this->display(null, ['errors' => $errors]);
    }

    public function edit($id)
    {
        $id = (int)($id[1] ?? 0);
        $record = PostModel::getInstance()->getRecord($id);
        $errors = false;

        if (!$record) {
            header('HTTP/1.0 404 Not Found');
            exit('Post not found');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $updated = PostRepository::update($id, $_POST, $_FILES, $record);
            if ($updated) {
                header('Location: ' . AppUtil::url(['ctl' => 'post', 'act' => 'view', 'params' => [$id]]));
                exit();
            } else {
                $errors = "Please fill in all required fields.";
            }
        }

        $this->display(null, [
            'record' => $record,
            'errors' => $errors
        ]);
    }

    public function del($id)
    {
        $id = (int)$id[1];

        if (!PostRepository::delete($id)) {
            header('HTTP/1.0 404 Not Found');
            exit('Post not found');
        }

        header('Location:' . AppUtil::url(['ctl' => 'post']));
        exit();
    }

    public function search()
    {
        $keyword = trim($_GET['keyword'] ?? '');

        if (empty($keyword)) {
            header('Location:' . AppUtil::url(['ctl' => 'post']));
            exit();
        }

        $limit = 10;
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $offset = ($page - 1) * $limit;

        $model = PostModel::getInstance();
        $posts = $model->search(['title','content'], $keyword, $limit, $offset);
        $totalResults = $model->countSearch(['title','content'], $keyword);
        $totalPages = ceil($totalResults / $limit);

        $this->display(null, [
            'listPosts'    => $posts,
            'totalPages'   => $totalPages,
            'currentPage'  => $page,
            'keyword'      => $keyword,
        ]);
    }

    public function uploadCkEditor() {
        if (!isset($_FILES['upload']) || $_FILES['upload']['error'] !== UPLOAD_ERR_OK) {
            header('Content-Type: application/json');
            echo json_encode(['error' => ['message' => 'File upload failed']]);
            return;
        }

        $path = UploadService::upload($_FILES, ['folder' => 'ckeditor'], 'upload');
        
        if ($path) {
            header('Content-Type: application/json');
            echo json_encode([
                'url' => UploadREL . 'ckeditor/' . $path
            ]);
        } else {
            echo json_encode(['error' => ['message' => 'Unable to save file']]);
        }
    }
}