<?php
class AccountController extends MainController {
    public function index() {
        AuthMiddleware::check();
        $userId = $_SESSION['user']['id'] ?? 0;
        $posts = PURepository::getPostsByUserId($userId)['posts'] ?? [];
        $this->display(null, ['posts' => $posts]);
    }

    public function edit() {
        AuthMiddleware::check();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['new_password'])) {
                $this->handlePasswordChange();
            } else {
                $this->handleProfileUpdate();
            }
        }
        $this->display();
    }

    protected function handleProfileUpdate() {
        $userId = $_SESSION['user']['id'];
        $result = AccountService::updateProfile($userId, $_POST, $_FILES['avatar'] ?? null);

        if (isset($result['error'])) {
            $_SESSION['error'] = $result['error'];
        } elseif (isset($result['success'])) {
            $_SESSION['user'] = UserModel::getInstance()->getUserById($userId);
            $_SESSION['success'] = "Profile updated successfully!";
        } elseif (isset($result['info'])) {
            $_SESSION['info'] = $result['info'];
        }

        header("Location: " . AppUtil::url(['ctl' => 'account', 'act' => 'edit']));
        exit;
    }

    protected function handlePasswordChange() {
        $userId = $_SESSION['user']['id'];
        $result = AccountService::changePassword(
            $userId,
            $_POST['current_password'] ?? '',
            $_POST['new_password'] ?? '',
            $_POST['confirm_password'] ?? ''
        );

        if (isset($result['success'])) {
            $_SESSION['success'] = $result['success'];
            header("Location: " . AppUtil::url(['ctl' => 'account', 'act' => 'edit']));
            exit;
        } else {
            $_SESSION['error'] = $result['error'];
        }

        $this->display();
        exit;
    }

    public function checkExist() {
        header('Content-Type: application/json');
        $type = $_GET['type'] ?? '';
        $value = trim($_GET['value'] ?? '');
        $userId = $_SESSION['user']['id'] ?? 0;

        $exists = false;
        if ($type && $value) {
            $exists = AccountService::checkExist($type, $value, $userId);
        }

        echo json_encode(['exists' => $exists]);
        exit;
    }
}