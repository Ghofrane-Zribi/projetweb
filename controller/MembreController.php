<?php
// C:\xampp\htdocs\projetweb-test\controller\MembreController.php
require_once 'model/manager/MembreManager.php';
require_once 'model/manager/EtudiantManager.php';
require_once 'model/manager/ClubManager.php';

class MembreController {
    private $membreManager;
    private $etudiantManager;
    private $clubManager;

    public function __construct() {
        $this->membreManager = new MembreManager();
        $this->etudiantManager = new EtudiantManager();
        $this->clubManager = new ClubManager();
    }

    public function list() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=admin&action=login');
            exit;
        }

        try {
            $membres = $this->membreManager->findAll();
            $etudiants = $this->etudiantManager->findAll();
            $clubs = $this->clubManager->findAll();
            require 'view/membre/list.php';
        } catch (Exception $e) {
            $error = "Erreur lors de la récupération des membres : " . $e->getMessage();
            require 'view/membre/list.php';
        }
    }

    public function create() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=admin&action=login');
            exit;
        }
        $etudiants = $this->etudiantManager->findAll();
        $clubs = $this->clubManager->findAll();
        require 'view/membre/create.php';
    }

    public function store() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=admin&action=login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_etudiant = filter_input(INPUT_POST, 'id_etudiant', FILTER_VALIDATE_INT);
            $id_club = filter_input(INPUT_POST, 'id_club', FILTER_VALIDATE_INT);
            $date_inscription = filter_input(INPUT_POST, 'date_inscription', FILTER_SANITIZE_STRING);
            $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);

            if (!$id_etudiant || !$id_club || !$date_inscription || !$role) {
                $error = "Tous les champs sont obligatoires.";
                $etudiants = $this->etudiantManager->findAll();
                $clubs = $this->clubManager->findAll();
                require 'view/membre/create.php';
                return;
            }

            if ($this->membreManager->findByEtudiantAndClub($id_etudiant, $id_club)) {
                $error = "Cet étudiant est déjà membre de ce club.";
                $etudiants = $this->etudiantManager->findAll();
                $clubs = $this->clubManager->findAll();
                require 'view/membre/create.php';
                return;
            }

            try {
                $membre = new Membre(null, $id_etudiant, $id_club, $date_inscription, $role);
                $this->membreManager->create($membre);
                header('Location: ?controller=membre&action=list');
                exit;
            } catch (Exception $e) {
                $error = "Erreur lors de la création du membre : " . $e->getMessage();
                $etudiants = $this->etudiantManager->findAll();
                $clubs = $this->clubManager->findAll();
                require 'view/membre/create.php';
            }
        } else {
            header('Location: ?controller=membre&action=create');
            exit;
        }
    }

    public function edit($id) {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=admin&action=login');
            exit;
        }
        $membre = $this->membreManager->findById($id);
        if (!$membre) {
            $error = "Membre non trouvé.";
            require 'view/membre/edit.php';
            return;
        }
        $etudiants = $this->etudiantManager->findAll();
        $clubs = $this->clubManager->findAll();
        require 'view/membre/edit.php';
    }

    public function update($id) {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=admin&action=login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $membre = $this->membreManager->findById($id);
            if (!$membre) {
                $error = "Membre non trouvé.";
                require 'view/membre/edit.php';
                return;
            }

            $id_etudiant = filter_input(INPUT_POST, 'id_etudiant', FILTER_VALIDATE_INT);
            $id_club = filter_input(INPUT_POST, 'id_club', FILTER_VALIDATE_INT);
            $date_inscription = filter_input(INPUT_POST, 'date_inscription', FILTER_SANITIZE_STRING);
            $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);

            if (!$id_etudiant || !$id_club || !$date_inscription || !$role) {
                $error = "Tous les champs sont obligatoires.";
                $etudiants = $this->etudiantManager->findAll();
                $clubs = $this->clubManager->findAll();
                require 'view/membre/edit.php';
                return;
            }

            $existing = $this->membreManager->findByEtudiantAndClub($id_etudiant, $id_club);
            if ($existing && $existing->getIdMembre() != $id) {
                $error = "Cet étudiant est déjà membre de ce club.";
                $etudiants = $this->etudiantManager->findAll();
                $clubs = $this->clubManager->findAll();
                require 'view/membre/edit.php';
                return;
            }

            try {
                $membre->setIdEtudiant($id_etudiant);
                $membre->setIdClub($id_club);
                $membre->setDateInscription($date_inscription);
                $membre->setRole($role);
                $this->membreManager->update($membre);
                header('Location: ?controller=membre&action=list');
                exit;
            } catch (Exception $e) {
                $error = "Erreur lors de la mise à jour : " . $e->getMessage();
                $etudiants = $this->etudiantManager->findAll();
                $clubs = $this->clubManager->findAll();
                require 'view/membre/edit.php';
            }
        } else {
            header('Location: ?controller=membre&action=edit&id=' . urlencode($id));
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
            $membre = $this->membreManager->findById($id);
            if ($membre) {
                $this->membreManager->delete($id);
            }
            header('Location: ?controller=membre&action=list');
            exit;
        } catch (Exception $e) {
            $error = "Erreur lors de la suppression : " . $e->getMessage();
            require 'view/membre/list.php';
        }
    }
}
?>