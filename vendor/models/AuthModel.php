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
            $remember_me_token = $remember['remeber_me_token'];
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
}