<?php
// C:\xampp\htdocs\projetweb-test\index.php


require_once 'controller/EtudiantController.php';
require_once 'controller/AdminController.php';
require_once 'controller/ClubController.php';
require_once 'controller/AdhesionController.php';

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'etudiant';
$action = isset($_GET['action']) ? $_GET['action'] : 'list';
$id = isset($_GET['id']) ? $_GET['id'] : null;

switch ($controller) {
    case 'etudiant':
        $etudiantController = new EtudiantController();
        switch ($action) {
            case 'list':
                $etudiantController->list();
                break;
            case 'create':
                $etudiantController->create();
                break;
            case 'store':
                $etudiantController->store();
                break;
            case 'edit':
                $etudiantController->edit($id);
                break;
            case 'update':
                $etudiantController->update($id);
                break;
            case 'delete':
                $etudiantController->delete($id);
                break;
            case 'login':
                $etudiantController->login();
                break;
            case 'logout':
                $etudiantController->logout();
                break;
            default:
                $etudiantController->list();
        }
        break;

    case 'admin':
        $adminController = new AdminController();
        switch ($action) {
            case 'list':
                $adminController->list();
                break;
            case 'create':
                $adminController->create();
                break;
            case 'store':
                $adminController->store();
                break;
            case 'edit':
                $adminController->edit($id);
                break;
            case 'update':
                $adminController->update($id);
                break;
            case 'delete':
                $adminController->delete($id);
                break;
            case 'login':
                $adminController->login();
                break;
            case 'logout':
                $adminController->logout();
                break;
            case 'dashboard':
                $adminController->dashboard();
                break;
            default:
                $adminController->list();
        }
        break;

    case 'club':
        $clubController = new ClubController();
        switch ($action) {
            case 'list':
                $clubController->list();
                break;
            case 'create':
                $clubController->create();
                break;
            case 'store':
                $clubController->store();
                break;
            case 'edit':
                $clubController->edit($id);
                break;
            case 'update':
                $clubController->update($id);
                break;
            case 'delete':
                $clubController->delete($id);
                break;
            default:
                $clubController->list();
        }
        break;

    case 'adhesion':
        $adhesionController = new AdhesionController();
        switch ($action) {
            case 'list':
                $adhesionController->list();
                break;
            case 'create':
                $adhesionController->create();
                break;
            case 'store':
                $adhesionController->store();
                break;
            case 'edit':
                $adhesionController->edit($id);
                break;
            case 'update':
                $adhesionController->update($id);
                break;
            case 'delete':
                $adhesionController->delete($id);
                break;
            default:
                $adhesionController->list();
        }
        break;

    default:
        $etudiantController = new EtudiantController();
        $etudiantController->list();
}
?>