<?php //include_once "config/main.php"; ?> 
<?php //include_once "views/admin/dashboard/index.php" ?>

<?php
include_once(__DIR__.'/config/main.php');
include_once(__DIR__.'/vendor/bootstrap/autoload.php');
include_once(__DIR__.'/vendor/bootstrap/app.php');

// ROUTER SIMPLE
$ctl = isset($_GET['ctl']) ? $_GET['ctl'] : 'home';
$act = isset($_GET['act']) ? $_GET['act'] : 'index';

$controllerName = ucfirst($ctl) . 'Controller';
$controllerFile = __DIR__ . '/controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    include_once($controllerFile);
    if (class_exists($controllerName)) {
        $controller = new $controllerName();
        if (method_exists($controller, $act)) {
            $controller->$act();
            exit;
        }
    }
}

// Nếu không tìm thấy controller/action thì chuyển về trang chủ hoặc báo lỗi
header("Location: " . RootREL);
exit;