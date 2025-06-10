<?php 
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $domain = isset($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] : 'localhost';
    $port = isset($_SERVER["SERVER_PORT"]) ? $_SERVER["SERVER_PORT"] : 80;

    if ($port != 80) {
        $domain .= ":" . $port;
    }

    $relRoot = isset($_SERVER["SCRIPT_NAME"]) ? dirname($_SERVER["SCRIPT_NAME"]) : '/';
    if (substr($relRoot, -1) != '/') {
        $relRoot .= '/';
    }

    define('RootURL', 'http://'.$domain.$relRoot);
    define('RootABS', 'http://'.$domain.$relRoot);
    define('RootREL', $relRoot);
    define('MediaREL', 'media/');
    define('MediaURI', $relRoot.'media/');
    define('UploadREL', 'media/uploads/');
    define('UploadURI', $relRoot.UploadREL);
    define('RootURI', dirname($_SERVER['SCRIPT_FILENAME'])."/");

    define('ControllerREL', 'controllers/');
    define('AdminPath', 'admin');
    define('ControllerAdminREL', ControllerREL."/".AdminPath);

    define('DefaultImgW', 600);
    // Global variables
    $app = [];
    $app['area'] = 'users';
    $app['areaPath'] = '';

    $app['roles'] = [
        '1' => 'admin',
        '2' => 'user'
    ];

    $app['recordTime'] = [
        'created' => 'created_at',
        'updated' => 'updated_at'
    ];

    $app['months'] = [
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'May',
        'Jun',
        'Jul',
        'Aug',
        'Sep',
        'Oct',
        'Nov',
        'Dece',
    ];
    $app['weekdays'] = [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday'
    ];
    $mediaFiles = [
        'css' => [],
        'js' => []
    ];
    $obMediaFiles = $mediaFiles;
    include_once(__DIR__.'/database.php');

    $enableOB = true;
?>