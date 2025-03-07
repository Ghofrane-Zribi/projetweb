<?php
// controller/AdminC.php
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../model/entite/Admin.php';
require_once __DIR__ . '/../model/manager/AdminManager.php';

class AdminC {
    public function login() {
        session_start();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pdo = Database::getConnection();
            
            // Récupération des données
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            // Requête directe
            $stmt = $pdo->prepare("SELECT * FROM admins WHERE email = ?");
            $stmt->execute([$email]);
            $admin = $stmt->fetch();
            
            if ($admin && password_verify($password, $admin['password'])) {
                $_SESSION['admin_connected'] = true;
                header('Location: index.php?action=admin_ok');
                exit;
            } else {
                echo "Identifiants incorrects ou compte inexistant";
            }
        }
        
        include 'view/admin/login.php';
    }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit;
    }
?>