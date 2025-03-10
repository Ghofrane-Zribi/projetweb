<?php
// C:\xampp\htdocs\projetweb-test\controller\BackofficeController.php

require_once 'model/manager/AdminManager.php';
require_once 'model/manager/EtudiantManager.php';
require_once 'model/manager/ClubManager.php';
require_once 'model/manager/AdhesionManager.php';
require_once 'model/manager/MembreManager.php';
require_once 'core/Database.php';

class BackofficeController {
    private $adminManager;
    private $etudiantManager;
    private $clubManager;
    private $adhesionManager;
    private $membreManager;

    public function __construct() {
        $this->adminManager = new AdminManager();
        $this->etudiantManager = new EtudiantManager();
        $this->clubManager = new ClubManager();
        $this->adhesionManager = new AdhesionManager();
        $this->membreManager = new MembreManager();
    }

    public function login() {
        if (isset($_SESSION['admin_id'])) {
            header('Location: ?controller=backoffice&action=dashboard');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $mot_de_passe = $_POST['mot_de_passe'];
            $admin = $this->adminManager->login($email, $mot_de_passe);
            if ($admin) {
                $_SESSION['admin_id'] = $admin->getIdAdmin();
                header('Location: ?controller=backoffice&action=dashboard');
                exit;
            } else {
                $error = "Email ou mot de passe incorrect.";
                require_once 'view/backoffice/login.php';
            }
        } else {
            require_once 'view/backoffice/login.php';
        }
    }

    public function logout() {
        session_destroy();
        header('Location: ?controller=backoffice&action=login');
        exit;
    }

    public function dashboard() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=backoffice&action=login');
            exit;
        }

        try {
            $clubs = $this->clubManager->findAll();
            $adhesions = $this->adhesionManager->findAll();
            $etudiants = $this->etudiantManager->findAll();
            $membres = $this->membreManager->findAll();

            // Statistique globale : Nombre total d'étudiants
            $totalEtudiants = count($etudiants);

            // Statistique globale : Nombre total de clubs
            $totalClubs = count($clubs);

            // Statistique globale : Nombre total d'adhésions
            $totalAdhesions = count($adhesions);

            // Statistique globale : Taux d'acceptation global
            $adhesionsAcceptees = array_filter($adhesions, fn($a) => $a->getStatut() == 'accepté');
            $tauxAcceptationGlobal = $totalAdhesions > 0 ? (count($adhesionsAcceptees) / $totalAdhesions) * 100 : 0;

            // Statistiques : Nombre d'étudiants par club (via la table membres)
            $statsEtudiantsParClub = [];
            foreach ($clubs as $club) {
                $nbEtudiants = 0;
                foreach ($membres as $membre) {
                    if ($membre->getIdClub() == $club->getIdClub()) {
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

            // Statistiques : Taux d'acceptation par club
            $tauxAcceptationParClub = [];
            foreach ($clubs as $club) {
                $adhesionsClub = array_filter($adhesions, fn($a) => $a->getIdClub() == $club->getIdClub());
                $adhesionsAccepteesClub = array_filter($adhesionsClub, fn($a) => $a->getStatut() == 'accepté');
                $totalAdhesionsClub = count($adhesionsClub);
                $tauxAcceptationParClub[$club->getIdClub()] = $totalAdhesionsClub > 0 ? (count($adhesionsAccepteesClub) / $totalAdhesionsClub) * 100 : 0;
            }

            // Statistiques : Rôles par club (on récupère les noms des étudiants pour chaque rôle)
            $nomsRolesParClub = [];
            foreach ($clubs as $club) {
                $roles = [
                    'président' => null,
                    'trésorier' => null,
                    'secrétaire' => null,
                    'membre' => 0 // On garde un compteur pour les membres simples
                ];
                foreach ($membres as $membre) {
                    if ($membre->getIdClub() == $club->getIdClub()) {
                        $etudiant = array_filter($etudiants, fn($e) => $e->getIdEtudiant() == $membre->getIdEtudiant());
                        $etudiant = reset($etudiant);
                        $nomComplet = $etudiant ? $etudiant->getNom() . ' ' . $etudiant->getPrenom() : 'Inconnu';
                        $role = $membre->getRole();
                        if ($role == 'membre') {
                            $roles['membre']++;
                        } else {
                            $roles[$role] = $nomComplet; // On stocke le nom pour président, trésorier, secrétaire
                        }
                    }
                }
                $nomsRolesParClub[$club->getIdClub()] = $roles;
            }

            // Statistique globale : Répartition des rôles (on garde les compteurs ici)
            $repartitionRoles = ['membre' => 0, 'président' => 0, 'trésorier' => 0, 'secrétaire' => 0];
            foreach ($membres as $membre) {
                $role = $membre->getRole();
                if (isset($repartitionRoles[$role])) {
                    $repartitionRoles[$role]++;
                }
            }

            require 'view/backoffice/dashboard.php';
        } catch (Exception $e) {
            $error = "Erreur lors de la récupération des données pour le tableau de bord : " . $e->getMessage();
            require 'view/admin/dashboard.php';
        }
    }

    public function adminList() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=backoffice&action=login');
            exit;
        }
        $admins = $this->adminManager->findAll();
        require_once 'view/backoffice/admin_list.php';
    }

    public function adminCreate() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=backoffice&action=login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $mot_de_passe = $_POST['mot_de_passe'];
            $admin = new Admin(null, $email, $mot_de_passe, date('Y-m-d H:i:s'));
            if ($this->adminManager->create($admin)) {
                header('Location: ?controller=backoffice&action=adminList');
                exit;
            } else {
                $error = "Erreur lors de l'ajout de l'admin.";
                require_once 'view/backoffice/admin_create.php';
            }
        } else {
            require_once 'view/backoffice/admin_create.php';
        }
    }

    public function adminEdit($id) {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=backoffice&action=login');
            exit;
        }
        $admin = $this->adminManager->findById($id);
        if (!$admin) {
            header('Location: ?controller=backoffice&action=adminList');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $mot_de_passe = $_POST['mot_de_passe'] ? $_POST['mot_de_passe'] : $admin->getPasswordHash();
            $admin->setEmail($email);
            $admin->setPasswordHash($mot_de_passe);
            $admin->setCreatedAt(date('Y-m-d H:i:s'));
            if ($this->adminManager->update($admin)) {
                header('Location: ?controller=backoffice&action=adminList');
                exit;
            } else {
                $error = "Erreur lors de la modification de l'admin.";
                require_once 'view/backoffice/admin_edit.php';
            }
        } else {
            require_once 'view/backoffice/admin_edit.php';
        }
    }

    public function adminDelete($id) {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=backoffice&action=login');
            exit;
        }
        if ($this->adminManager->delete($id)) {
            header('Location: ?controller=backoffice&action=adminList');
            exit;
        } else {
            $error = "Erreur lors de la suppression de l'admin.";
            $admins = $this->adminManager->findAll();
            require_once 'view/backoffice/admin_list.php';
        }
    }

    public function etudiantList() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=backoffice&action=login');
            exit;
        }
        $etudiants = $this->etudiantManager->findAll();
        require_once 'view/backoffice/etudiant_list.php';
    }

    public function etudiantCreate() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=backoffice&action=login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $mot_de_passe = $_POST['mot_de_passe'];
            $date_naissance = $_POST['date_naissance'];
            $cv = $_POST['cv'];
            $etudiant = new Etudiant(null, $nom, $prenom, $email, $mot_de_passe, $date_naissance, $cv);
            if ($this->etudiantManager->create($etudiant)) {
                header('Location: ?controller=backoffice&action=etudiantList');
                exit;
            } else {
                $error = "Erreur lors de l'ajout de l'étudiant.";
                require_once 'view/backoffice/etudiant_create.php';
            }
        } else {
            require_once 'view/backoffice/etudiant_create.php';
        }
    }

    public function etudiantEdit($id) {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=backoffice&action=login');
            exit;
        }
        $etudiant = $this->etudiantManager->findById($id);
        if (!$etudiant) {
            header('Location: ?controller=backoffice&action=etudiantList');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];
            $mot_de_passe = $_POST['mot_de_passe'] ? $_POST['mot_de_passe'] : $etudiant->getMotDePasse();
            $date_naissance = $_POST['date_naissance'];
            $cv = $_POST['cv'];
            $etudiant->setNom($nom);
            $etudiant->setPrenom($prenom);
            $etudiant->setEmail($email);
            $etudiant->setMotDePasse($mot_de_passe);
            $etudiant->setDateNaissance($date_naissance);
            $etudiant->setCv($cv);
            if ($this->etudiantManager->update($etudiant)) {
                header('Location: ?controller=backoffice&action=etudiantList');
                exit;
            } else {
                $error = "Erreur lors de la modification de l'étudiant.";
                require_once 'view/backoffice/etudiant_edit.php';
            }
        } else {
            require_once 'view/backoffice/etudiant_edit.php';
        }
    }

    public function etudiantDelete($id) {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=backoffice&action=login');
            exit;
        }
        if ($this->etudiantManager->delete($id)) {
            header('Location: ?controller=backoffice&action=etudiantList');
            exit;
        } else {
            $error = "Erreur lors de la suppression de l'étudiant.";
            $etudiants = $this->etudiantManager->findAll();
            require_once 'view/backoffice/etudiant_list.php';
        }
    }

    public function clubList() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=backoffice&action=login');
            exit;
        }
        $clubs = $this->clubManager->findAll();
        require_once 'view/backoffice/club_list.php';
    }

    public function clubCreate() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=backoffice&action=login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom_club = $_POST['nom_club'];
            $description = $_POST['description'];
            $date_creation = $_POST['date_creation'];
            $reseaux_sociaux = ''; // À ajuster selon votre formulaire
            $logo = ''; // À ajuster selon votre formulaire
            $club = new Club(null, $nom_club, $date_creation, $description, $reseaux_sociaux, $logo);
            if ($this->clubManager->create($club)) {
                header('Location: ?controller=backoffice&action=clubList');
                exit;
            } else {
                $error = "Erreur lors de l'ajout du club.";
                require_once 'view/backoffice/club_create.php';
            }
        } else {
            require_once 'view/backoffice/club_create.php';
        }
    }
    public function clubstore() {
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

            if ($this->clubManager->findByNomClub($nom_club)) {
                $error = "Ce nom de club est déjà utilisé.";
                require 'view/club/create.php';
                return;
            }

            try {
                $club = new Club(null, $nom_club, $date_creation, $description, $reseaux_sociaux, $logo);
                $this->clubManager->create($club);
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

    public function clubEdit($id) {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=backoffice&action=login');
            exit;
        }
        $club = $this->clubManager->findById($id);
        if (!$club) {
            header('Location: ?controller=backoffice&action=clubList');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom_club = $_POST['nom_club'];
            $description = $_POST['description'];
            $date_creation = $_POST['date_creation'];
            $reseaux_sociaux = $club->getReseauxSociaux(); // À ajuster selon votre formulaire
            $logo = $club->getLogo(); // À ajuster selon votre formulaire
            $club->setNomClub($nom_club);
            $club->setDescription($description);
            $club->setDateCreation($date_creation);
            $club->setReseauxSociaux($reseaux_sociaux);
            $club->setLogo($logo);
            if ($this->clubManager->update($club)) {
                header('Location: ?controller=backoffice&action=clubList');
                exit;
            } else {
                $error = "Erreur lors de la modification du club.";
                require_once 'view/backoffice/club_edit.php';
            }
        } else {
            require_once 'view/backoffice/club_edit.php';
        }
    }

    public function clubDelete($id) {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=backoffice&action=login');
            exit;
        }
        if ($this->clubManager->delete($id)) {
            header('Location: ?controller=backoffice&action=clubList');
            exit;
        } else {
            $error = "Erreur lors de la suppression du club.";
            $clubs = $this->clubManager->findAll();
            require_once 'view/backoffice/club_list.php';
        }
    }

    public function adhesionList() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=backoffice&action=login');
            exit;
        }
        $adhesions = $this->adhesionManager->findAll();
        $etudiants = $this->etudiantManager->findAll();
        $etudiants = array_reduce($etudiants, function($carry, $etudiant) {
            $carry[$etudiant->getIdEtudiant()] = $etudiant;
            return $carry;
        }, []);
        $clubs = $this->clubManager->findAll();
        $clubs = array_reduce($clubs, function($carry, $club) {
            $carry[$club->getIdClub()] = $club;
            return $carry;
        }, []);
        require_once 'view/backoffice/adhesion_list.php';
    }

    public function adhesionCreate() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=backoffice&action=login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_etudiant = $_POST['id_etudiant'];
            $id_club = $_POST['id_club'];
            $date_adhesion = $_POST['date_adhesion'];
            $statut = $_POST['statut'];
            $adhesion = new Adhesion(null, $id_etudiant, $id_club, $date_adhesion, $statut);
            if ($this->adhesionManager->create($adhesion)) {
                header('Location: ?controller=backoffice&action=adhesionList');
                exit;
            } else {
                $error = "Erreur lors de l'ajout de l'adhésion.";
                require_once 'view/backoffice/adhesion_create.php';
            }
        } else {
            $etudiants = $this->etudiantManager->findAll();
            $clubs = $this->clubManager->findAll();
            require_once 'view/backoffice/adhesion_create.php';
        }
    }
    public function membrestore() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=backoffice&action=login');
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
                require 'view/backoffice/membre_create.php';
                return;
            }

            if ($this->membreManager->findByEtudiantAndClub($id_etudiant, $id_club)) {
                $error = "Cet étudiant est déjà membre de ce club.";
                $etudiants = $this->etudiantManager->findAll();
                $clubs = $this->clubManager->findAll();
                require 'view/backoffice/membre_create.php';
                return;
            }

            try {
                $membre = new Membre(null, $id_etudiant, $id_club, $date_inscription, $role);
                $this->membreManager->create($membre);
                header('Location: ?controller=backoffice&action=membreCreate');
                exit;
            } catch (Exception $e) {
                $error = "Erreur lors de la création du membre : " . $e->getMessage();
                $etudiants = $this->etudiantManager->findAll();
                $clubs = $this->clubManager->findAll();
                require 'view/backoffice/membre_create.php';
            }
        } else {
            header('Location: ?controller=backoffice&action=membreCreate');
            exit;
        }
    }

    public function adhesionEdit($id) {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=backoffice&action=login');
            exit;
        }
        $adhesion = $this->adhesionManager->findById($id);
        if (!$adhesion) {
            header('Location: ?controller=backoffice&action=adhesionList');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_etudiant = $_POST['id_etudiant'];
            $id_club = $_POST['id_club'];
            $date_adhesion = $_POST['date_adhesion'];
            $statut = $_POST['statut'];
            $adhesion->setIdEtudiant($id_etudiant);
            $adhesion->setIdClub($id_club);
            $adhesion->setDateDemande($date_adhesion);
            $adhesion->setStatut($statut);
            if ($this->adhesionManager->update($adhesion)) {
                header('Location: ?controller=backoffice&action=adhesionList');
                exit;
            } else {
                $error = "Erreur lors de la modification de l'adhésion.";
                require_once 'view/backoffice/adhesion_edit.php';
            }
        } else {
            $etudiants = $this->etudiantManager->findAll();
            $clubs = $this->clubManager->findAll();
            require_once 'view/backoffice/adhesion_edit.php';
        }
    }

    public function adhesionDelete($id) {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=backoffice&action=login');
            exit;
        }
        if ($this->adhesionManager->delete($id)) {
            header('Location: ?controller=backoffice&action=adhesionList');
            exit;
        } else {
            $error = "Erreur lors de la suppression de l'adhésion.";
            $adhesions = $this->adhesionManager->findAll();
            $etudiants = $this->etudiantManager->findAll();
            $etudiants = array_reduce($etudiants, function($carry, $etudiant) {
                $carry[$etudiant->getIdEtudiant()] = $etudiant;
                return $carry;
            }, []);
            $clubs = $this->clubManager->findAll();
            $clubs = array_reduce($clubs, function($carry, $club) {
                $carry[$club->getIdClub()] = $club;
                return $carry;
            }, []);
            require_once 'view/backoffice/adhesion_list.php';
        }
    }

    public function membreList() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=backoffice&action=login');
            exit;
        }
        $membres = $this->membreManager->findAll();
        $etudiants = $this->etudiantManager->findAll();
        $etudiants = array_reduce($etudiants, function($carry, $etudiant) {
            $carry[$etudiant->getIdEtudiant()] = $etudiant;
            return $carry;
        }, []);
        $clubs = $this->clubManager->findAll();
        $clubs = array_reduce($clubs, function($carry, $club) {
            $carry[$club->getIdClub()] = $club;
            return $carry;
        }, []);
        require_once 'view/backoffice/membre_list.php';
    }

    public function membreCreate() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=backoffice&action=login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_etudiant = $_POST['id_etudiant'];
            $id_club = $_POST['id_club'];
            $role = $_POST['role'];
            $membre = new Membre(null, $id_etudiant, $id_club, date('Y-m-d'), $role);
            if ($this->membreManager->create($membre)) {
                header('Location: ?controller=backoffice&action=membreList');
                exit;
            } else {
                $error = "Erreur lors de l'ajout du membre.";
                require_once 'view/backoffice/membre_create.php';
            }
        } else {
            $etudiants = $this->etudiantManager->findAll();
            $clubs = $this->clubManager->findAll();
            require_once 'view/backoffice/membre_create.php';
        }
    }

    public function membreEdit($id) {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=backoffice&action=login');
            exit;
        }
        $membre = $this->membreManager->findById($id);
        if (!$membre) {
            header('Location: ?controller=backoffice&action=membreList');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_etudiant = $_POST['id_etudiant'];
            $id_club = $_POST['id_club'];
            $role = $_POST['role'];
            $membre->setIdEtudiant($id_etudiant);
            $membre->setIdClub($id_club);
            $membre->setRole($role);
            if ($this->membreManager->update($membre)) {
                header('Location: ?controller=backoffice&action=membreList');
                exit;
            } else {
                $error = "Erreur lors de la modification du membre.";
                require_once 'view/backoffice/membre_edit.php';
            }
        } else {
            $etudiants = $this->etudiantManager->findAll();
            $clubs = $this->clubManager->findAll();
            require_once 'view/backoffice/membre_edit.php';
        }
    }

    public function membreDelete($id) {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?controller=backoffice&action=login');
            exit;
        }
        if ($this->membreManager->delete($id)) {
            header('Location: ?controller=backoffice&action=membreList');
            exit;
        } else {
            $error = "Erreur lors de la suppression du membre.";
            $membres = $this->membreManager->findAll();
            $etudiants = $this->etudiantManager->findAll();
            $etudiants = array_reduce($etudiants, function($carry, $etudiant) {
                $carry[$etudiant->getIdEtudiant()] = $etudiant;
                return $carry;
            }, []);
            $clubs = $this->clubManager->findAll();
            $clubs = array_reduce($clubs, function($carry, $club) {
                $carry[$club->getIdClub()] = $club;
                return $carry;
            }, []);
            require_once 'view/backoffice/membre_list.php';
        }
    }
}
?>