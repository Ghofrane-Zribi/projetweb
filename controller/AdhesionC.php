<?php
require_once __DIR__ . '/../core/Database.php'; 
require_once __DIR__ . '/../model/entite/Adhesion.php';
require_once __DIR__ . '/../model/manager/AdhesionManager.php';
require_once __DIR__ . '/../model/manager/EtudiantManager.php';
require_once __DIR__ . '/../model/manager/ClubManager.php';

class AdhesionC {
    private $adhesionManager;
    private $etudiantManager;
    private $clubManager;

    public function __construct() {
        $this->adhesionManager = new AdhesionManager();
        $this->etudiantManager = new EtudiantManager();
        $this->clubManager = new ClubManager();
    }

    public function listAdhesions() {
        try {
            $adhesions = $this->adhesionManager->findAll();
            include '../view/adhesion/listadhesion.php';
        } catch (Exception $e) {
            $this->handleError($e);
        }
    }

    public function showAdhesion($id_adhesion) {
        try {
            $adhesion = $this->adhesionManager->find($id_adhesion);
            return $adhesion;
        } catch (Exception $e) {
            $this->handleError($e);
        }
    }

    // Dans AdhesionC.php
public function addAdhesion(Adhesion $adhesion) {
    // Vérifie l'existence de l'étudiant
    $etudiantManager = new EtudiantManager();
    if (!$etudiantManager->exists($adhesion->getIdEtudiant())) {
        throw new Exception("L'étudiant n'existe pas");
    }

    // Vérifie l'existence du club
    $clubManager = new ClubManager();
    if (!$clubManager->exists($adhesion->getIdClub())) {
        throw new Exception("Le club n'existe pas");
    }

    // Crée l'adhésion
    $this->adhesionManager->create($adhesion);
}

    public function deleteAdhesion($id_adhesion) {
        try {
            $this->adhesionManager->delete($id_adhesion);
            header("Location: listadhesion.php?success=Adhésion supprimée");
        } catch (Exception $e) {
            $this->handleError($e);
        }
    }

    public function updateAdhesion(Adhesion $adhesion) {
        try {
            $this->adhesionManager->update($adhesion);
            header("Location: listadhesion.php?success=Adhésion mise à jour");
        } catch (Exception $e) {
            $this->handleError($e);
        }
    }

    private function handleError(Exception $e) {
        http_response_code(500);
        error_log($e->getMessage()); // Log en production
        header("Location: error.php?message=" . urlencode($e->getMessage()));
        exit();
    }
}
?>