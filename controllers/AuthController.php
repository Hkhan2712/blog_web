<?php
class AuthController extends MainController {
    protected $errors = false;

    public function __construct()
    {  
        global $app;
        $rolesFlip = array_flip($app['roles']);
        if (isset($_SESSION['user']['role'])) {
            if (AuthModel::getInstance()->isAdmin()) {
                header("Location: ".AppUtil::url(['ctl' => 'dashboard'])); die();
            }
            if (AuthModel::getInstance()->isUser()) {
                header("Location: ".AppUtil::url()); die();
            }
        }
        parent::__construct();
    }

    public function login() {
        if (isset($_POST['btn_submit'])) {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember']);

            $result = AuthService::login($email, $password, $remember);

            if ($result === true) {
                $role = $_SESSION['user']['role'] ?? '';
                $redirect = ($role === 'admin')
                    ? AppUtil::url(['ctl' => 'dashboard'])
                    : AppUtil::url(['ctl' => 'home']);
                header("Location: $redirect"); exit;
            } elseif (is_array($result)) {
                $this->errors = $result;
            } else {
                $this->errors = ['message' => 'Can not login with your account!'];
            }
        }

        $this->display();
    }

    public function register() {
        if (isset($_POST['btn_submit'])) {
            $data = [
                'username' => $_POST['username'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => $_POST['password'] ?? '',
                'repeat_password' => $_POST['repeat_password'] ?? '',
            ];

            $result = AuthService::register($data);

            if ($result === true) {
                header("Location: " . AppUtil::url(['ctl' => 'auth', 'act' => 'login']));
                exit;
            } elseif (is_array($result)) {
                $this->errors = $result;
            } else {
                $this->errors = ['message' => 'Can not register with your account!'];
            }
        }

        $this->display();
    }

    public function logout() {
        AuthService::logout();
        header("Location: " . AppUtil::url(['ctl' => 'auth', 'act' => 'login']));
        exit;
    }
}