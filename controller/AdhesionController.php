<?php
// C:\xampp\htdocs\projetweb-test\controller\AdhesionController.php
require_once 'model/manager/AdhesionManager.php';
require_once 'model/manager/EtudiantManager.php';
require_once 'model/manager/ClubManager.php';

class AdhesionController {
    private $manager;
    private $etudiantManager;
    private $clubManager;

    public function __construct() {
        $this->manager = new AdhesionManager();
        $this->etudiantManager = new EtudiantManager();
        $this->clubManager = new ClubManager();
    }

    public function list() {
        try {
            $adhesions = $this->manager->findAll();
            $etudiants = $this->etudiantManager->findAll();
            $clubs = $this->clubManager->findAll();
            require 'view/adhesion/list.php';
        } catch (Exception $e) {
            $error = "Erreur lors de la récupération des adhésions : " . $e->getMessage();
            require 'view/adhesion/list.php';
        }
    }

    public function create() {
        $etudiants = $this->etudiantManager->findAll();
        $clubs = $this->clubManager->findAll();
        require 'view/adhesion/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_etudiant = filter_input(INPUT_POST, 'id_etudiant', FILTER_VALIDATE_INT);
            $id_club = filter_input(INPUT_POST, 'id_club', FILTER_VALIDATE_INT);
            $statut = filter_input(INPUT_POST, 'statut', FILTER_SANITIZE_STRING);

            if (!$id_etudiant || !$id_club || !$statut) {
                $error = "L'étudiant, le club et le statut sont obligatoires.";
                $etudiants = $this->etudiantManager->findAll();
                $clubs = $this->clubManager->findAll();
                require 'view/adhesion/create.php';
                return;
            }

            try {
                $adhesion = new Adhesion(null, $id_etudiant, $id_club, null, $statut);
                $this->manager->create($adhesion);
                header('Location: ?controller=adhesion&action=list');
                exit;
            } catch (Exception $e) {
                $error = "Erreur lors de la création de l'adhésion : " . $e->getMessage();
                $etudiants = $this->etudiantManager->findAll();
                $clubs = $this->clubManager->findAll();
                require 'view/adhesion/create.php';
            }
        } else {
            header('Location: ?controller=adhesion&action=create');
            exit;
        }
    }

    public function edit($id) {
        $adhesion = $this->manager->findById($id);
        $etudiants = $this->etudiantManager->findAll();
        $clubs = $this->clubManager->findAll();
        if (!$adhesion) {
            $error = "Adhésion non trouvée.";
            require 'view/adhesion/edit.php';
            return;
        }
        require 'view/adhesion/edit.php';
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adhesion = $this->manager->findById($id);
            if (!$adhesion) {
                $error = "Adhésion non trouvée.";
                require 'view/adhesion/edit.php';
                return;
            }

            $id_etudiant = filter_input(INPUT_POST, 'id_etudiant', FILTER_VALIDATE_INT);
            $id_club = filter_input(INPUT_POST, 'id_club', FILTER_VALIDATE_INT);
            $statut = filter_input(INPUT_POST, 'statut', FILTER_SANITIZE_STRING);

            if (!$id_etudiant || !$id_club || !$statut) {
                $error = "L'étudiant, le club et le statut sont obligatoires.";
                $etudiants = $this->etudiantManager->findAll();
                $clubs = $this->clubManager->findAll();
                require 'view/adhesion/edit.php';
                return;
            }

            try {
                $adhesion->setIdEtudiant($id_etudiant);
                $adhesion->setIdClub($id_club);
                $adhesion->setStatut($statut);
                $this->manager->update($adhesion);
                header('Location: ?controller=adhesion&action=list');
                exit;
            } catch (Exception $e) {
                $error = "Erreur lors de la mise à jour : " . $e->getMessage();
                $etudiants = $this->etudiantManager->findAll();
                $clubs = $this->clubManager->findAll();
                require 'view/adhesion/edit.php';
            }
        } else {
            header('Location: ?controller=adhesion&action=edit&id=' . urlencode($id));
            exit;
        }
    }

    public function delete($id) {
        try {
            $adhesion = $this->manager->findById($id);
            if ($adhesion) {
                $this->manager->delete($id);
            }
            header('Location: ?controller=adhesion&action=list');
            exit;
        } catch (Exception $e) {
            $error = "Erreur lors de la suppression : " . $e->getMessage();
            require 'view/adhesion/list.php';
        }
    }
}
?>