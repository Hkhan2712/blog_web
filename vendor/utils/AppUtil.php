<?php
class AppUtil {
    public static function url($options = null) {

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