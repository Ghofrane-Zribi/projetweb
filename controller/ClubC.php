<?php
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../model/entite/Club.php';
require_once __DIR__ . '/../model/manager/ClubManager.php';

class ClubC {
    private $clubManager;

    public function __construct() {
        $this->clubManager = new ClubManager();
    }

    public function listClubs() {
        $clubs = $this->clubManager->findAll();
        include __DIR__ . '/../../view/club/listclub.php';
    }

    public function addClub(Club $club) {
        $this->clubManager->create($club);
        header("Location: listclub.php?success=Club ajouté");
    }

    public function deleteClub($id) {
        $this->clubManager->delete($id);
        header("Location: listclub.php?success=Club supprimé");
    }

    public function updateClub(Club $club) {
        $this->clubManager->update($club);
        header("Location: listclub.php?success=Club mis à jour");
    }

    public function showClub($id) {
        return $this->clubManager->find($id);
    }
}
?>