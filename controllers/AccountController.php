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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['new_password'])) {
                $this->changePassword();
            } else {
                $this->changeProfile();
            }
        }
        $this->display();
    }
    protected function changeProfile() {
        $userId = $_SESSION['user']['id'];
        $um = UserModel::getInstance();
        
        $datas = [
            'firstname'    => trim($_POST['firstname'] ?? ''),
            'lastname'     => trim($_POST['lastname'] ?? ''),
            'username'     => trim($_POST['username'] ?? ''),
            'email'        => trim($_POST['email'] ?? ''),
            'display_name' => trim($_POST['display_name'] ?? ''),
            'bio'          => trim($_POST['bio'] ?? ''),
        ];

        $datas = array_filter($datas, fn($v) => $v !== null && $v !== '');

        if (isset($datas['username'])) {
            $userWithSameUsername = $um->getRecordWhere([
                'username' => $datas['username'],
                [
                    [
                        'field' => 'id',
                        'comparisonOp' => '!=',
                        'value' => $userId
                    ]
                ]
            ]);
            if ($userWithSameUsername) {
                $_SESSION['error'] = "Username is already taken.";
                header("Location: " . AppUtil::url(['ctl' => 'account', 'act' => 'edit']));
                exit;
            }
        }

        if (isset($datas['email'])) {
            $userWithSameEmail = $um->getRecordWhere([
                'email' => $datas['email'],
                [
                    [
                        'field' => 'id',
                        'comparisonOp' => '!=',
                        'value' => $userId
                    ]
                ]
            ]);
            if ($userWithSameEmail) {
                $_SESSION['error'] = "Email is already in use.";
                header("Location: " . AppUtil::url(['ctl' => 'account', 'act' => 'edit']));
                exit;
            }
        }

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $image = $this->uploadImg($_FILES, ['folder' => 'users'], 'avatar');
            $datas['avatar_url'] = $image; 
        }

        if (!empty($datas)) {
            $um->updateWhere($datas, "id = $userId");
            $_SESSION['user'] = $um->getUserById($userId);
            $_SESSION['success'] = "Profile updated successfully!";
        } else {
            $_SESSION['info'] = "No changes were made.";
        }

        header("Location: " . AppUtil::url(['ctl' => 'account', 'act' => 'edit']));
        exit;
    }

    protected function changePassword() {
        $userId = $_SESSION['user']['id'];
        $um = UserModel::getInstance();

        $currentPassword = md5($_POST['current_password'] ?? '');
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $user = $um->getUserById($userId);

        if (!$user || $user['password'] !== $currentPassword) {
            $_SESSION['error'] = "Current password is incorrect.";
        } elseif (strlen($newPassword) < 6) {
            $_SESSION['error'] = "New password must be at least 6 characters.";
        } elseif ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = "New passwords do not match.";
        } else {
            $hashedPassword = md5($newPassword); 
            $um->updateWhere(['password' => $hashedPassword], "id = $userId");
            $_SESSION['success'] = "Password changed successfully!";
            header("Location: " . AppUtil::url(['ctl' => 'account', 'act' => 'edit']));
            exit;
        }
        var_dump($_SESSION['error']); $this->display(); exit;
    }
    public function checkExist() {
        // AuthMiddleware::check();

        header('Content-Type: application/json');

        $type = $_GET['type'] ?? '';
        $value = trim($_GET['value'] ?? '');
        $userId = $_SESSION['user']['id'] ?? 0;

        // DEBUG LOG
        error_log("checkExist CALLED: type=$type, value=$value, userId=$userId");

        if (!$type || !$value) {
            echo json_encode(['exists' => false]);
            return;
        }

        $um = UserModel::getInstance();
        $conditions = [
            $type => $value,
            [
                [
                    'field' => 'id',
                    'comparisonOp' => '!=',
                    'value' => $userId
                ]
            ]
        ];
        $exists = (bool)$um->getRecordWhere($conditions);

        echo json_encode([
            'debug' => ['type' => $type, 'value' => $value, 'userId' => $userId, 'conditions' => $conditions],
            'exists' => $exists
        ]);
        exit;
    }
}