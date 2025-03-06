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

    // Getters
    public function getIdAdhesion() {
        return $this->id_adhesion;
    }

    public function getIdEtudiant() {
        return $this->id_etudiant;
    }

    public function getIdClub() {
        return $this->id_club;
    }

    public function getStatut() {
        return $this->statut;
    }

    public function setIdEtudiant($id_etudiant) {
        $this->id_etudiant = $id_etudiant;
    }

    public function setIdClub($id_club) {
        $this->id_club = $id_club;
    }

    public function setStatut($statut) {
        $this->statut = $statut;
    }

    public function ajouterAdhesion() {
        $pdo = Database::getConnection();
        $sql = "INSERT INTO adhesions (id_etudiant, id_club, statut) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->id_etudiant, $this->id_club, $this->statut]);
    }

    public static function getAllAdhesions() {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM adhesions");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAdhesionById($id_adhesion) 
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM adhesions WHERE id_adhesion = ?");
        $stmt->execute([$id_adhesion]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retourne un tableau associatif
    }

    public function updateAdhesion($id_adhesion) {
        $pdo = Database::getConnection();
        $sql = "UPDATE adhesions SET id_etudiant = ?, id_club = ?, statut = ? WHERE id_adhesion = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->id_etudiant, $this->id_club, $this->statut, $id_adhesion]);
    }

    public static function deleteAdhesion($id_adhesion) {
        $pdo = Database::getConnection();
        $sql = "DELETE FROM adhesions WHERE id_adhesion = ?";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$id_adhesion]);
    }
}
?>