<?php
// C:\xampp\htdocs\projetweb-test\controller\ClubController.php
require_once 'model/manager/ClubManager.php';

class ClubController {
    private $manager;

    public function __construct() {
        $this->manager = new ClubManager();
    }

    public function list() {
        try {
            $clubs = $this->manager->findAll();
            require 'view/club/list.php';
        } catch (Exception $e) {
            $error = "Erreur lors de la récupération des clubs : " . $e->getMessage();
            require 'view/club/list.php';
        }
    }

    public function create() {
        require 'view/club/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom_club = filter_input(INPUT_POST, 'nom_club', FILTER_SANITIZE_STRING);
            $date_creation = filter_input(INPUT_POST, 'date_creation', FILTER_SANITIZE_STRING);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $reseaux_sociaux = filter_input(INPUT_POST, 'reseaux_sociaux', FILTER_SANITIZE_STRING);
            $logo = filter_input(INPUT_POST, 'logo', FILTER_SANITIZE_STRING);

            if (!$nom_club || !$date_creation) {
                $error = "Le nom du club et la date de création sont obligatoires.";
                require 'view/club/create.php';
                return;
            }

            if ($this->manager->findByNomClub($nom_club)) {
                $error = "Ce nom de club est déjà utilisé.";
                require 'view/club/create.php';
                return;
            }

            try {
                $club = new Club(null, $nom_club, $date_creation, $description, $reseaux_sociaux, $logo);
                $this->manager->create($club);
                header('Location: ?controller=club&action=list');
                exit;
            } catch (Exception $e) {
                $error = "Erreur lors de la création du club : " . $e->getMessage();
                require 'view/club/create.php';
            }
        } else {
            header('Location: ?controller=club&action=create');
            exit;
        }
    }

    public function edit($id) {
        $club = $this->manager->findById($id);
        if (!$club) {
            $error = "Club non trouvé.";
            require 'view/club/edit.php';
            return;
        }
        require 'view/club/edit.php';
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $club = $this->manager->findById($id);
            if (!$club) {
                $error = "Club non trouvé.";
                require 'view/club/edit.php';
                return;
            }

            $nom_club = filter_input(INPUT_POST, 'nom_club', FILTER_SANITIZE_STRING);
            $date_creation = filter_input(INPUT_POST, 'date_creation', FILTER_SANITIZE_STRING);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            $reseaux_sociaux = filter_input(INPUT_POST, 'reseaux_sociaux', FILTER_SANITIZE_STRING);
            $logo = filter_input(INPUT_POST, 'logo', FILTER_SANITIZE_STRING);

            if (!$nom_club || !$date_creation) {
                $error = "Le nom du club et la date de création sont obligatoires.";
                require 'view/club/edit.php';
                return;
            }

            $existing = $this->manager->findByNomClub($nom_club);
            if ($existing && $existing->getIdClub() != $id) {
                $error = "Ce nom de club est déjà utilisé par un autre club.";
                require 'view/club/edit.php';
                return;
            }

            try {
                $club->setNomClub($nom_club);
                $club->setDateCreation($date_creation);
                $club->setDescription($description);
                $club->setReseauxSociaux($reseaux_sociaux);
                $club->setLogo($logo);
                $this->manager->update($club);
                header('Location: ?controller=club&action=list');
                exit;
            } catch (Exception $e) {
                $error = "Erreur lors de la mise à jour : " . $e->getMessage();
                require 'view/club/edit.php';
            }
        } else {
            header('Location: ?controller=club&action=edit&id=' . urlencode($id));
            exit;
        }
    }

    public function delete($id) {
        try {
            $club = $this->manager->findById($id);
            if ($club) {
                $this->manager->delete($id);
            }
            header('Location: ?controller=club&action=list');
            exit;
        } catch (Exception $e) {
            $error = "Erreur lors de la suppression : " . $e->getMessage();
            require 'view/club/list.php';
        }
    }
}
?>