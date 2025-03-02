<?php
require_once "../Config.php";

class Adhesion {
    private $id_adhesion;
    private $id_etudiant;
    private $id_club;
    private $statut;

    public function __construct($id_etudiant, $id_club, $statut = "en attente") {
        $this->id_etudiant = $id_etudiant;
        $this->id_club = $id_club;
        $this->statut = $statut;
    }

    public function ajouterDemande() {
        $pdo = Database::getConnection();
        $sql = "INSERT INTO adhesions (id_etudiant, id_club, statut) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->id_etudiant, $this->id_club, $this->statut]);
    }

    public static function validerAdhesion($id_adhesion) {
        $pdo = Database::getConnection();
        $sql = "UPDATE adhesions SET statut = 'accepté' WHERE id_adhesion = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$id_adhesion]);
    }

    public static function refuserAdhesion($id_adhesion) {
        $pdo = Database::getConnection();
        $sql = "UPDATE adhesions SET statut = 'refusé' WHERE id_adhesion = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$id_adhesion]);
    }
}
?>
