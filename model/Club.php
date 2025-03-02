<?php
require_once "../Config.php";

class Club {
    private $id_club;
    private $nom_club;
    private $date_creation;
    private $description;
    private $reseaux_sociaux;
    private $logo;

    public function __construct($nom, $date, $desc, $reseaux, $logo) {
        $this->nom_club = $nom;
        $this->date_creation = $date;
        $this->description = $desc;
        $this->reseaux_sociaux = $reseaux;
        $this->logo = $logo;
    }

    // Méthodes getters pour chaque propriété privée
    public function getNomClub() {
        return $this->nom_club;
    }

    public function getDateCreation() {
        return $this->date_creation;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getReseauxSociaux() {
        return $this->reseaux_sociaux;
    }

    public function getLogo() {
        return $this->logo;
    }

    public function ajouterClub() {
        $pdo = Database::getConnection();
        $sql = "INSERT INTO clubs (nom_club, date_creation, description, reseaux_sociaux, logo) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->nom_club, $this->date_creation, $this->description, $this->reseaux_sociaux, $this->logo]);
    }

    public static function getAllClubs() {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM clubs");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
