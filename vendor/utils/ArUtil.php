<?php 
class ArUtil {
    public static function isMultiArray($arr) {
        rsort($arr);
        return isset($arr[0]) && is_array($arr[0]);
    }
}