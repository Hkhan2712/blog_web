<?php
class AppUtil {
    public static function url($options = null) {
        if ($options == '/') 
            return 'index.php';
        global $app;
        if (!isset($options['area'])) {
            if ($app['area'] == 'users')
                $options['area'] = '';
            else $options['area'] = $app['area'].'/';
        } else {
            $options['area'] = ($options['area']) ? $options['area'].'/': '';
        }
        if (!isset($options['ctl'])) {
            $options['ctl'] = $app['ctl'];
        }
        $act = '';
        if (isset($options['act'])) {
            $act = '/'.$options['act'];
        }

        $params = '';
        if (isset($options['params']) and $options['params']) {
            foreach ($options['params'] as $k => $v) {
                $params .= (is_numeric($k)) ? '/'.$v: '/'.$k.'='.$v;
            }
        }
        return RootREL.$options['area'].$options['ctl'].$act.$params;
    }
    public static function isMultiArray($arr) {
        $rv = array_filter($arr, 'is_array');
        rsort($arr);
        if (count($rv) > 0) return true;
        return false;
    }
    public static function generatePassword($strPass) {
        return md5($strPass);
    }
    public static function hashStr() {
        $salt = strtr(substr(base64_encode(random_bytes(16)), 0, 22), '+', '.');
        $identify = sprintf('$2y$%02d$', 10) . $salt;
        return $identify;
    }
}