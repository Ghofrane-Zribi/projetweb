<?php
// C:\xampp\htdocs\projetweb-test\controller\EtudiantController.php
require_once 'model/manager/EtudiantManager.php';

class EtudiantController {
    private $manager;

    public function __construct() {
        $this->manager = new EtudiantManager();
    }

    public function list() {
        
        try {
            $etudiants = $this->manager->findAll();
            require 'view/etudiant/list.php';
        } catch (Exception $e) {
            $error = "Erreur lors de la récupération des étudiants : " . $e->getMessage();
            require 'view/etudiant/list.php';
        }
    }

    public function create() {
        
        require 'view/etudiant/create.php';
    }

    public function store() {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
            $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $mot_de_passe = $_POST['mot_de_passe'];
            $date_naissance = filter_input(INPUT_POST, 'date_naissance', FILTER_SANITIZE_STRING);
            $cv = filter_input(INPUT_POST, 'cv', FILTER_SANITIZE_STRING);

            if (!$nom || !$prenom || !$email || !$mot_de_passe) {
                $error = "Tous les champs obligatoires doivent être remplis avec des valeurs valides.";
                require 'view/etudiant/create.php';
                return;
            }

            $existing = $this->manager->findByEmail($email);
            if ($existing) {
                $error = "Cet email est déjà utilisé.";
                require 'view/etudiant/create.php';
                return;
            }

            try {
                $etudiant = new Etudiant(null, $nom, $prenom, $email, $mot_de_passe, $date_naissance, $cv);
                $this->manager->create($etudiant);
                header('Location: ?controller=etudiant&action=list');
                exit;
            } catch (Exception $e) {
                $error = "Erreur lors de la création de l'étudiant : " . $e->getMessage();
                require 'view/etudiant/create.php';
            }
        } else {
            header('Location: ?controller=etudiant&action=create');
            exit;
        }
    }

    public function edit($id) {
        
        $etudiant = $this->manager->findById($id);
        if (!$etudiant) {
            $error = "Étudiant non trouvé.";
            require 'view/etudiant/edit.php';
            return;
        }
        require 'view/etudiant/edit.php';
    }

    public function update($id) {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $etudiant = $this->manager->findById($id);
            if (!$etudiant) {
                $error = "Étudiant non trouvé.";
                require 'view/etudiant/edit.php';
                return;
            }

            $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
            $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $mot_de_passe = $_POST['mot_de_passe'];
            $date_naissance = filter_input(INPUT_POST, 'date_naissance', FILTER_SANITIZE_STRING);
            $cv = filter_input(INPUT_POST, 'cv', FILTER_SANITIZE_STRING);

            if (!$nom || !$prenom || !$email) {
                $error = "Les champs nom, prénom et email sont obligatoires.";
                require 'view/etudiant/edit.php';
                return;
            }

            $existing = $this->manager->findByEmail($email);
            if ($existing && $existing->getIdEtudiant() != $id) {
                $error = "Cet email est déjà utilisé par un autre étudiant.";
                require 'view/etudiant/edit.php';
                return;
            }

            try {
                $etudiant->setNom($nom);
                $etudiant->setPrenom($prenom);
                $etudiant->setEmail($email);
                if (!empty($mot_de_passe)) {
                    $etudiant->setMotDePasse($mot_de_passe);
                }
                $etudiant->setDateNaissance($date_naissance);
                $etudiant->setCv($cv);
                $this->manager->update($etudiant);
                header('Location: ?controller=etudiant&action=list');
                exit;
            } catch (Exception $e) {
                $error = "Erreur lors de la mise à jour : " . $e->getMessage();
                require 'view/etudiant/edit.php';
            }
        } else {
            header('Location: ?controller=etudiant&action=edit&id=' . urlencode($id));
            exit;
        }
    }

    public function delete($id) {
        
        try {
            $etudiant = $this->manager->findById($id);
            if ($etudiant) {
                $this->manager->delete($id);
            }
            header('Location: ?controller=etudiant&action=list');
            exit;
        } catch (Exception $e) {
            $error = "Erreur lors de la suppression : " . $e->getMessage();
            require 'view/etudiant/list.php';
        }
    }

    public function login() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $mot_de_passe = $_POST['mot_de_passe'];

            if (!$email || !$mot_de_passe) {
                $error = "Email et mot de passe sont obligatoires.";
                require 'view/etudiant/login.php';
                return;
            }

            $etudiant = $this->manager->findByEmail($email);
            if ($etudiant && password_verify($mot_de_passe, $etudiant->getMotDePasse())) {
                $_SESSION['etudiant_id'] = $etudiant->getIdEtudiant();
                header('Location: ?controller=etudiant&action=list');
                exit;
            } else {
                $error = "Email ou mot de passe incorrect.";
                require 'view/etudiant/login.php';
            }
        } else {
            if (isset($_SESSION['etudiant_id'])) {
                header('Location: ?controller=etudiant&action=list');//direction apres login
                exit;
            }
            require 'view/etudiant/login.php';
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: ?controller=etudiant&action=login');
        exit;
    }
}
?>