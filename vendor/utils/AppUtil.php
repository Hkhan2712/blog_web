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
}