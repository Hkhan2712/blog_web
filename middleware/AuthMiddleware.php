<?php
class AuthMiddleware {
    public static function check() {
        if (empty($_SESSION['user'])) {
            $_SESSION['error'] = "You must log in first.";
            header("Location: " . AppUtil::url(['ctl' => 'auth', 'act' => 'login']));
            exit;
        }
    }
}
