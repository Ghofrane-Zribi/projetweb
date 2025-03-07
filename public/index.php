<?php
// public/index.php
require_once '../core/Config.php';
require_once '../core/Database.php';

$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'admin_login':
        (new AdminC())->login();
        break;
        
    case 'admin_ok':
        require '../view/admin/admin_ok.php';
        break;
}
session_start();

// Routage basique
$page = $_GET['page'] ?? 'home';

try {
    switch ($page) {
        case 'login':
            require '../controller/EtudiantC.php';
            (new EtudiantC())->login();
            break;
            
        case 'dashboard':
            require '../controller/AdminC.php';
            (new AdminC())->dashboard();
            break;
            
        default:
            require '../view/home.php';
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    http_response_code(500);
    require '../view/error.php';
}
?>