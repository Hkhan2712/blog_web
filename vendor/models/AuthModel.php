<?php
class AuthModel extends MainModel {
    public function login($user = null, $admin = false, $remember = null) {
        $result = null;
        $um = new UserModel();
        if ($user) {
            $email = $user['email'];
            $password = AppUtil::generatePassword($user['password']);
            $result = $um->getRecordWhere([
                'email' => $email,
                'status' => 1,
                'password' => $password
            ]);
        }

        if ($remember) {
            $remember_me_identify = $remember['remember_me_identify'];
            $remember_me_token = $remember['remember_me_token'];
            $result = $um->getRecordWhere([
                'remember_me_identify' => HtmlHelper::processSQLString($remember_me_identify),
                'remember_me_token' => HtmlHelper::processSQLString($remember_me_token),
            ]);
        }

        if ($result) {
            $row = $result;
            $_SESSION['user'] = $row;
            if (isset($_POST['remember'])) {
                $time = time()+60*60*24*100;
                $identify = AppUtil::hashStr();
                $code = crypt($_POST['user']['password'], $identify);
                if ($um->editRecord($row['id'],[
                    'remember_me_identify' => $identify,
                    'remember_me_token' => $code
                ]))
                setcookie("remember_me", $identify.':'.$code, $time, "/");
            }
            if ($admin) {
                global $app;
                $rolesFlip = array_flip($app['roles']);
                if ($row['role'] != $rolesFlip['admin']) return 0;
            }
            return 1;
        }
        return 0;
    }
    public function register($user) {
        $um = new UserModel();
        $user['username'] = isset($user['username']) ? $user['username'] : '';
        $user['email'] = isset($user['email']) ? $user['email'] : '';
        $user['password_hash'] = AppUtil::generatePassword($user['password_hash']);
        $user['status'] = 1; // Mặc định là active
        return $um->addRecord($user);
    }
    public function isLoggedIn() {
        return isset($_SESSION['user']) && !empty($_SESSION['user']);
    }
    public function isAdmin() {
        global $app;
        $rolesFlip = array_flip($app['roles']);
        return isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == $rolesFlip['admin'];
    }
    public function isUser() {
        global $app;
        $rolesFlip = array_flip($app['roles']);
        return isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == $rolesFlip['user'];
    }
    public function getUser() {
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }
    public function getUserId() {
        return isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : null;
    }
    public function getUserRole() {
        return isset($_SESSION['user']['role']) ? $_SESSION['user']['role'] : null;
    }
    public function getUserName() {
        return isset($_SESSION['user']['name']) ? $_SESSION['user']['name'] : null;
    }
    public function getUserEmail() {
        return isset($_SESSION['user']['email']) ? $_SESSION['user']['email'] : null;
    }
    public function getUserAvatar() {
        return isset($_SESSION['user']['avatar']) ? $_SESSION['user']['avatar'] : null;
    }
}