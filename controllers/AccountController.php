<?php
class AccountController extends MainController {
    protected $posts;

    public function index() {
        AuthMiddleware::check();
        $pm = PostModel::getInstance();
        $userId = $_SESSION['user']['id'] ?? 0;
        $this->posts = $pm->getPostsByUserId($userId);
        $this->display();
    }

    public function edit() {
        AuthMiddleware::check();
        $userId = $_SESSION['user']['id'];
        $um = UserModel::getInstance();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datas = [
                'firstname'    => trim($_POST['firstname'] ?? ''),
                'lastname'     => trim($_POST['lastname'] ?? ''),
                'username'     => trim($_POST['username'] ?? ''),
                'email'        => trim($_POST['email'] ?? ''),
                'display_name' => trim($_POST['display_name'] ?? ''),
                'bio'          => trim($_POST['bio'] ?? ''),
            ];
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $image = $this->uploadImg($_FILES, ['folder' => 'users'], 'avatar');
                $datas['avatar_url'] = $image; // Chỉ thêm avatar_url nếu có ảnh mới
            }
            // Update user using your updateWhere()
            $um->updateWhere($datas, "id = $userId");

            // Refresh session
            $_SESSION['user'] = $um->one("id = $userId");
            var_dump($_SESSION['user']); exit;
            $_SESSION['success'] = "Profile updated successfully!";
            header("Location: " . AppUtil::url(['ctl' => 'account', 'act' => 'edit']));
            exit;
        }

        $this->display();
    }
}