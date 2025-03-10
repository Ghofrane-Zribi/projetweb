<?php
// C:\xampp\htdocs\projetweb-test\controller\FrontofficeController.php

require_once 'model/manager/EtudiantManager.php';
require_once 'model/manager/ClubManager.php';
require_once 'model/manager/AdhesionManager.php';
require_once 'model/manager/MembreManager.php';
require_once 'core/Database.php';

class FrontofficeController {
    private $etudiantManager;
    private $clubManager;
    private $adhesionManager;
    private $membreManager;

    public function __construct() {
        $this->etudiantManager = new EtudiantManager();
        $this->clubManager = new ClubManager();
        $this->adhesionManager = new AdhesionManager();
        $this->membreManager = new MembreManager();
    }

    public function login() {
        if (isset($_SESSION['etudiant_id'])) {
            header('Location: ?controller=frontoffice&action=clubs_list');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $mot_de_passe = $_POST['mot_de_passe'];
            $etudiant = $this->etudiantManager->findByEmail($email);
            if ($etudiant && password_verify($mot_de_passe, $etudiant->getMotDePasse())) {
                $_SESSION['etudiant_id'] = $etudiant->getIdEtudiant();
                header('Location: ?controller=frontoffice&action=clubs_list');
                exit;
            } else {
                $error = "Email ou mot de passe incorrect.";
                require_once 'view/frontoffice/login.php';
            }
        } else {
            require_once 'view/frontoffice/login.php';
        }
    }

    public function logout() {
        session_destroy();
        header('Location: ?controller=frontoffice&action=login');
        exit;
    }

    public function register() {
        if (isset($_SESSION['etudiant_id'])) {
            header('Location: ?controller=frontoffice&action=clubs_list');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $mot_de_passe = $_POST['mot_de_passe'];
            $date_naissance = $_POST['date_naissance'];
            $cv = $_POST['cv'] ?? '';
            $etudiant = new Etudiant(null, $nom, $prenom, $email, $mot_de_passe, $date_naissance, $cv);
            if ($this->etudiantManager->create($etudiant)) {
                header('Location: ?controller=frontoffice&action=login');
                exit;
            } else {
                $error = "Erreur lors de l'inscription.";
                require_once 'view/frontoffice/register.php';
            }
        } else {
            require_once 'view/frontoffice/register.php';
        }
    }

    public function clubs_list() {
        if (!isset($_SESSION['etudiant_id'])) {
            header('Location: ?controller=frontoffice&action=login');
            exit;
        }
        $clubs = $this->clubManager->findAll();
        require_once 'view/frontoffice/clubs_list.php';
    }

    public function club_details($id_club) {
        if (!isset($_SESSION['etudiant_id'])) {
            header('Location: ?controller=frontoffice&action=login');
            exit;
        }
    
        // Débogage
        error_log("club_details - id_club: " . $id_club);
    
        // Vérifier si l'id_club est valide
        if (!$id_club || !is_numeric($id_club)) {
            error_log("Erreur : id_club invalide dans club_details: " . $id_club);
            $error = "ID de club invalide.";
            $clubs = $this->clubManager->findAll();
            require_once 'view/frontoffice/clubs_list.php';
            return;
        }
    
        try {
            $club = $this->clubManager->findById($id_club);
            if (!$club) {
                error_log("Erreur : Club non trouvé pour id_club: " . $id_club);
                $error = "Club non trouvé.";
                $clubs = $this->clubManager->findAll();
                require_once 'view/frontoffice/clubs_list.php';
            } else {
                // Compter le nombre de membres du club
                $nombre_membres = $this->membreManager->countMembersByClub($id_club);
                error_log("Club trouvé : " . $club->getNomClub() . ", Nombre de membres : " . $nombre_membres);
                require_once 'view/frontoffice/club_details.php';
            }
        } catch (Exception $e) {
            error_log("Erreur dans club_details: " . $e->getMessage());
            $error = "Erreur lors de la récupération des détails du club : " . $e->getMessage();
            $clubs = $this->clubManager->findAll();
            require_once 'view/frontoffice/clubs_list.php';
        }
    }

    public function join_club($id_club) {
        if (!isset($_SESSION['etudiant_id'])) {
            header('Location: ?controller=frontoffice&action=login');
            exit;
        }
        $id_etudiant = $_SESSION['etudiant_id'];
        $date_demande = date('Y-m-d H:i:s');
        $statut = 'en attente';
        $adhesion = new Adhesion(null, $id_etudiant, $id_club, $date_demande, $statut);
        if ($this->adhesionManager->create($adhesion)) {
            // Vérifier si l'étudiant n'est pas déjà membre
            $membre = $this->membreManager->findByEtudiantAndClub($id_etudiant, $id_club);
            /*if (!$membre) {
                $membre = new Membre(null, $id_etudiant, $id_club, $date_demande, 'membre');
                $this->membreManager->create($membre);
            }*/
            header('Location: ?controller=frontoffice&action=clubs_list');
            exit;
        } else {
            $error = "Erreur lors de l'inscription au club.";
            $clubs = $this->clubManager->findAll();
            require_once 'view/frontoffice/clubs_list.php';
        }
    }

    public function profile() {
        if (!isset($_SESSION['etudiant_id'])) {
            header('Location: ?controller=frontoffice&action=login');
            exit;
        }
        $etudiant = $this->etudiantManager->findById($_SESSION['etudiant_id']);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $mot_de_passe = $_POST['mot_de_passe'] ?: $etudiant->getMotDePasse();
            $date_naissance = $_POST['date_naissance'];
            $cv = $_POST['cv'] ?? $etudiant->getCv();
            $etudiant->setNom($nom);
            $etudiant->setPrenom($prenom);
            $etudiant->setEmail($email);
            $etudiant->setMotDePasse($mot_de_passe);
            $etudiant->setDateNaissance($date_naissance);
            $etudiant->setCv($cv);
            if ($this->etudiantManager->update($etudiant)) {
                header('Location: ?controller=frontoffice&action=profile');
                exit;
            } else {
                $error = "Erreur lors de la modification du profil.";
                require_once 'view/frontoffice/profile.php';
            }
        } else {
            require_once 'view/frontoffice/profile.php';
        }
    }

    public function my_clubs() {
        if (!isset($_SESSION['etudiant_id'])) {
            header('Location: ?controller=frontoffice&action=login');
            exit;
        }
        $id_etudiant = $_SESSION['etudiant_id'];
    
        // Débogage
        error_log("my_clubs - id_etudiant: " . $id_etudiant);
    
        // Récupérer les membres de l'étudiant
        $membres = $this->membreManager->findByEtudiantAndClub($id_etudiant, null);
        error_log("Nombre de membres trouvés : " . count($membres));
    
        $clubs = [];
        foreach ($membres as $membre) {
            $id_club = $membre->getIdClub();
            $club = $this->clubManager->findById($id_club);
            if ($club) {
                $clubs[] = $club;
                error_log("Club trouvé pour id_club: " . $id_club . ", Nom: " . $club->getNomClub());
            } else {
                error_log("Aucun club trouvé pour id_club: " . $id_club);
            }
        }
    
        // Récupérer les demandes d'adhésion de l'étudiant
        $adhesions = $this->adhesionManager->findByEtudiant($id_etudiant);
        error_log("Nombre de demandes d'adhésion trouvées : " . count($adhesions));
    
        require_once 'view/frontoffice/my_clubs.php';
    }
}