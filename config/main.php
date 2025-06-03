<?php 
    $domain = $_SERVER["SERVER_NAME"];
    if ($_SERVER["SERVER_PORT"] != 80) 
        $domain .= ":".$_SERVER["SERVER_PORT"];
    $relRoot = dirname($_SERVER["SCRIPT_NAME"]);
    if (substr($relRoot, -1) != '/') {
        $relRoot .= '/';
    }
    define('RootREL', $relRoot);
    define('RootURI', dirname($_SERVER['SCRIPT_FILENAME']).'/');
    define('UploadREL', 'media/uploads/');
    define('UploadURI', $relRoot.UploadREL);
    // Config for Database
    define('DB_HOST', 'localhost');
    define('DB_USER', 'admin');
    define('DB_PASSWORD', 'Hkhan2712@');
    define('DB_NAME', 'blog');

    $app = [];
    $mediaFiles = [
        'css' => [],
        'js' => []
    ]
?>