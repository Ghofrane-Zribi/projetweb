<?php
// C:\xampp\htdocs\projetweb-test\controller\AdminController.php
require_once 'model/manager/AdminManager.php';

class AdminController {
    private $manager;

    public function __construct() {
        $this->manager = new AdminManager();
    }

    public function list() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=admin&action=login');
            exit;
        }

        try {
            $admins = $this->manager->findAll();
            require 'view/admin/list.php';
        } catch (Exception $e) {
            $error = "Erreur lors de la récupération des admins : " . $e->getMessage();
            require 'view/admin/list.php';
        }
    }

    public function create() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=admin&action=login');
            exit;
        }
        require 'view/admin/create.php';
    }

    public function store() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=admin&action=login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'];

            if (!$email || !$password) {
                $error = "Email et mot de passe sont obligatoires.";
                require 'view/admin/create.php';
                return;
            }

            if ($this->manager->findByEmail($email)) {
                $error = "Cet email est déjà utilisé.";
                require 'view/admin/create.php';
                return;
            }

            try {
                $admin = new Admin(null, $email, $password);
                $this->manager->create($admin);
                header('Location: ?controller=admin&action=list');
                exit;
            } catch (Exception $e) {
                $error = "Erreur lors de la création de l'admin : " . $e->getMessage();
                require 'view/admin/create.php';
            }
        } else {
            header('Location: ?controller=admin&action=create');
            exit;
        }
    }

    public function edit($id) {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=admin&action=login');
            exit;
        }
        $admin = $this->manager->findById($id);
        if (!$admin) {
            $error = "Admin non trouvé.";
            require 'view/admin/edit.php';
            return;
        }
        require 'view/admin/edit.php';
    }

    public function update($id) {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=admin&action=login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $admin = $this->manager->findById($id);
            if (!$admin) {
                $error = "Admin non trouvé.";
                require 'view/admin/edit.php';
                return;
            }

            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'];

            if (!$email) {
                $error = "L'email est obligatoire.";
                require 'view/admin/edit.php';
                return;
            }

            $existing = $this->manager->findByEmail($email);
            if ($existing && $existing->getIdAdmin() != $id) {
                $error = "Cet email est déjà utilisé par un autre admin.";
                require 'view/admin/edit.php';
                return;
            }

            try {
                $admin->setEmail($email);
                if (!empty($password)) {
                    $admin->setPasswordHash($password);
                }
                $this->manager->update($admin);
                header('Location: ?controller=admin&action=list');
                exit;
            } catch (Exception $e) {
                $error = "Erreur lors de la mise à jour : " . $e->getMessage();
                require 'view/admin/edit.php';
            }
        } else {
            header('Location: ?controller=admin&action=edit&id=' . urlencode($id));
            exit;
        }
    }

    public function delete($id) {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=admin&action=login');
            exit;
        }
        try {
            $admin = $this->manager->findById($id);
            if ($admin) {
                $this->manager->delete($id);
            }
            header('Location: ?controller=admin&action=list');
            exit;
        } catch (Exception $e) {
            $error = "Erreur lors de la suppression : " . $e->getMessage();
            require 'view/admin/list.php';
        }
    }

    public function login() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'];

            if (!$email || !$password) {
                $error = "Email et mot de passe sont obligatoires.";
                require 'view/admin/login.php';
                return;
            }

            $admin = $this->manager->findByEmail($email);
            if ($admin && password_verify($password, $admin->getPasswordHash())) {
                $_SESSION['admin_id'] = $admin->getIdAdmin();
                header('Location: ?controller=admin&action=list');
                exit;
            } else {
                $error = "Email ou mot de passe incorrect.";
                require 'view/admin/login.php';
            }
        } else {
            if (isset($_SESSION['admin_id'])) {
                header('Location: ?controller=admin&action=list');//direction apres login
                exit;
            }
            require 'view/admin/login.php';
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: ?controller=admin&action=login');
        exit;
    }
}
?>