<?php 
class AuthController extends MainController {
    protected $errors = false;
    // public function __construct()
    // {  
    //     global $app;
    //     $rolesFlip = array_flip($app['roles']);
    //     if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == $rolesFlip['user'] && $_SESSION['user']['role'] == 'admin') {
    //         header("Location: ".AppUtil::url(['ctl' => 'dashboard'])); die();
    //     } else {
    //         header("Location: ".AppUtil::url()); die();
    //     }
    //     parent::__construct();
    // }
    public function __construct()
    {  
        global $app;
        $rolesFlip = array_flip($app['roles']);
        if (isset($_SESSION['user']['role'])) {
            // Nếu là admin thì chuyển về dashboard
            // if ($_SESSION['user']['role'] == $rolesFlip['admin']) {
            //     header("Location: ".AppUtil::url(['ctl' => 'dashboard'])); die();
            // }
            // // Nếu là user thì chuyển về trang chủ
            // if ($_SESSION['user']['role'] == $rolesFlip['user']) {
            //     header("Location: ".AppUtil::url()); die();
            // }
            if (AuthModel::getInstance()->isAdmin()) {
                header("Location: ".AppUtil::url(['ctl' => 'dashboard'])); die();
            }
            if (AuthModel::getInstance()->isUser()) {
                header("Location: ".AppUtil::url()); die();
            }
        }
        parent::__construct();
    }
    public function index() {
        if (isset($_POST['btn_submit'])) {
            $user = $_POST['user'];
            $auth = AuthModel::getInstance();
            if ($auth->login($user)) {
                header("Location: ".AppUtil::url());
            } else {
                $this->errors = ['message' => 'Can not login with your account!'];   
            }
        }
        $this->display();
    }
    public function login() {
        if (isset($_POST['btn_submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            if (empty($email) || empty($password)) {
                $this->errors = ['message' => 'Email and password can not be empty!'];
                $this->display(); 
                return;
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->errors = ['message' => 'Email is not valid!'];
                $this->display(); 
                return;
            }
            $user = [
                'email' => $email,
                'password_hash' => $password,
            ];
            $auth = AuthModel::getInstance();
            if ($auth->login($user)) {
                header("Location: ".AppUtil::url(array('ctl' => 'home')));
            } else {
                $this->errors = ['message' => 'Can not login with your account!'];   
            }
        }
        $this->display();
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: ".AppUtil::url(array('ctl' => 'auth', 'act' => 'login')));
    }
    public function register() {
        if (isset($_POST['btn_submit'])) {
            $username = $_POST['username'];
            $email = $_POST['email'];
            if (empty($username) || empty($email)) {
                $this->errors = ['message' => 'Username and email can not be empty!'];
                $this->display(); 
                return;
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->errors = ['message' => 'Email is not valid!'];
                $this->display(); 
                return;
            }
            $password = $_POST['password_hash'];
            if (empty($password)) {
                $this->errors = ['message' => 'Password can not be empty!'];
                $this->display(); 
                return;
            }
            $user = [
                'username' => $username,
                'email' => $email,
                'password_hash' => $password,
            ];

            if ($_POST['password_hash'] != $_POST['repeat_password']) {
                $this->errors = ['message' => 'Passwords do not match!'];
                $this->display(); 
                return;
            }

            $auth = AuthModel::getInstance();
            if ($auth->register($user)) {
                header("Location: ".AppUtil::url(array('ctl' => 'auth', 'act' => 'login')));
            } else {
                $this->errors = ['message' => 'Can not register with your account!'];
            }
        }
        $this->display();
    }
}