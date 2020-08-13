<?php
namespace App;

require "../bootstrap.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (empty($_GET)) {
    echo "hello";
} else {
    $controller = filter_var($_GET['controller'], FILTER_SANITIZE_STRING);
    $method = filter_var($_GET['method'], FILTER_SANITIZE_STRING);
    switch ($_SERVER['REQUEST_METHOD']) {
        case 'GET':
            $params = explode('/', filter_var($_GET['params'], FILTER_SANITIZE_URL));
            break;
        case 'POST':
            if ($_SERVER['CONTENT_TYPE'] === 'application/json') {
                $json_str = file_get_contents('php://input');
                $params = [$json_str];
            } else {
                $params = $_POST;
            }
            break;
    }
    $classname = 'App\\Controller\\' . ucwords($controller) . 'Controller';
    if (method_exists($classname, $method) && !empty($params)) {
        $obj = new $classname;
        call_user_func_array([$obj, $method], $params);
    } else {
        $obj = new \App\Controller\BaseController;
        call_user_func([$obj, 'view']);
    }
}
