<?php
require_once 'app/config/config.php';

// Lấy URL từ .htaccess
$url = isset($_GET['url']) ? $_GET['url'] : 'sinhvien';
$url = rtrim($url, '/');
$url = explode('/', $url);

// Controller mặc định
$controller = isset($url[0]) ? $url[0] : 'sinhvien';
$action = isset($url[1]) ? $url[1] : 'index';
$param = isset($url[2]) ? $url[2] : null;

// Chuẩn hóa tên controller
$controllerName = ucfirst($controller) . 'Controller';
$controllerFile = 'app/controllers/' . $controllerName . '.php';

// Kiểm tra và load controller
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerName();
    
    // Kiểm tra method tồn tại
    if (method_exists($controller, $action)) {
        if ($param) {
            $controller->$action($param);
        } else {
            $controller->$action();
        }
    } else {
        die('Không tìm thấy trang yêu cầu');
    }
} else {
    die('Không tìm thấy trang yêu cầu');
}
