<?php 
class AuthService {
    public static function login($email, $password, $remember = false) {
        if (!AuthValidator::validate($email, $password)) {
            return false;
        } else {
            $hashedPassword = AppUtil::generatePassword($password);
            $um = UserModel::getInstance();
            $user = $um->getRecordWhere([
                'email' => $email,
                'password' => $hashedPassword,
                'status' => 1,
            ]);

            if (!$user) return ['message' => 'Email or passwrod is incorrect!'];

            if ($remember) {
                $identify = AppUtil::hashStr();
                $token = crypt($password, $identify);
                $um->editRecord($user['id'], [
                    'remember_me_identify' => $identify,
                    'remember_me_token' => $token,
                ]);
                setcookie("remember_me", "$identify:$token", time() + 8640000, "/"); // 100 days
            }

            $_SESSION['user'] = $user;
            return true;
        }
    }
    public static function register($data) {
        if (AuthValidator::validateRegister($data)) {
            $um = UserModel::getInstance();
            $existing = $um->getRecordWhere(['email' => $data['email']]);
            if ($existing) return ['message' => 'Email already exists!'];

            $data['password'] = AppUtil::generatePassword($data['password']);
            $data['status'] = 1;

            return $um->addRecord($data) ? true : ['message' => 'Registration failed!'];
        }
    }
    public static function isLoggedIn() : bool {
        return isset($_SESSION['user']) && !empty($_SESSION['user']);
    }
    
    public static function logout() {
        // // Xóa cookie remember_me nếu cần
        // if (isset($_COOKIE['remember_me'])) {
        //     setcookie('remember_me', '', time() - 3600, "/");
        // }

        // // Xóa session đúng cách
        // $_SESSION = [];
        // if (ini_get("session.use_cookies")) {
        //     $params = session_get_cookie_params();
        //     setcookie(session_name(), '', time() - 42000,
        //         $params["path"], $params["domain"],
        //         $params["secure"], $params["httponly"]
        //     );
        // }

        session_unset();
        session_destroy();
    }
}