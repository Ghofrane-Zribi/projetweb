<?php
// C:\xampp\htdocs\projetweb-test\controller\AdminController.php
require_once 'model/manager/AdminManager.php';
require_once 'model/manager/ClubManager.php';
require_once 'model/manager/AdhesionManager.php';
require_once 'model/manager/EtudiantManager.php';

class AdminController {
    private $adminManager;
    private $clubManager;
    private $adhesionManager;
    private $etudiantManager;

    public function __construct() {
        $this->adminManager = new AdminManager();
        $this->clubManager = new ClubManager();
        $this->adhesionManager = new AdhesionManager();
        $this->etudiantManager = new EtudiantManager();
    }

    public function list() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=admin&action=login');
            exit;
        }

        try {
            $admins = $this->adminManager->findAll();
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

            if ($this->adminManager->findByEmail($email)) {
                $error = "Cet email est déjà utilisé.";
                require 'view/admin/create.php';
                return;
            }

            try {
                $admin = new Admin(null, $email, $password);
                $this->adminManager->create($admin);
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
        $admin = $this->adminManager->findById($id);
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
            $admin = $this->adminManager->findById($id);
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

            $existing = $this->adminManager->findByEmail($email);
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
                $this->adminManager->update($admin);
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
            $admin = $this->adminManager->findById($id);
            if ($admin) {
                $this->adminManager->delete($id);
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

            $admin = $this->adminManager->findByEmail($email);
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
                header('Location: ?controller=admin&action=dashboard');
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

    public function dashboard() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=admin&action=login');
            exit;
        }

        try {
            $clubs = $this->clubManager->findAll();
            $adhesions = $this->adhesionManager->findAll();
            $etudiants = $this->etudiantManager->findAll();

            // Statistiques : Nombre d'étudiants par club
            $statsEtudiantsParClub = [];
            foreach ($clubs as $club) {
                $nbEtudiants = 0;
                foreach ($adhesions as $adhesion) {
                    if ($adhesion->getIdClub() == $club->getIdClub() && $adhesion->getStatut() == 'accepté') {
                        $nbEtudiants++;
                    }
                }
                $statsEtudiantsParClub[$club->getIdClub()] = $nbEtudiants;
            }

            // Statistiques : Nombre de demandes d'adhésion par club
            $statsDemandesParClub = [];
            foreach ($clubs as $club) {
                $nbDemandes = 0;
                foreach ($adhesions as $adhesion) {
                    if ($adhesion->getIdClub() == $club->getIdClub()) {
                        $nbDemandes++;
                    }
                }
                $statsDemandesParClub[$club->getIdClub()] = $nbDemandes;
            }

            // Statistique globale : Nombre total d'étudiants
            $totalEtudiants = count($etudiants);

            require 'view/admin/dashboard.php';
        } catch (Exception $e) {
            $error = "Erreur lors de la récupération des données pour le tableau de bord : " . $e->getMessage();
            require 'view/admin/dashboard.php';
        }
    }
}
?>