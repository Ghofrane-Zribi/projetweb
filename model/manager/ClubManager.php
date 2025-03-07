<?php
require_once __DIR__ . '/../../core/Database.php';
require_once __DIR__ . '/../entite/Club.php';

class ClubManager {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    // Récupère tous les clubs
    public function findAll() {
        $stmt = $this->pdo->query("
            SELECT 
                id_club AS id,
                nom_club AS nom,
                date_creation AS dateCreation,
                description,
                reseaux_sociaux AS reseauxSociaux,
                logo
            FROM clubs
        ");
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Club');
    }

    // Crée un nouveau club
    public function create(Club $club) {
        $sql = "INSERT INTO clubs 
                (nom_club, date_creation, description, reseaux_sociaux, logo)
                VALUES (:nom, :date, :desc, :rs, :logo)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nom' => $club->getNom(),
            ':date' => $club->getDateCreation(),
            ':desc' => $club->getDescription(),
            ':rs' => $club->getReseauxSociaux(),
            ':logo' => $club->getLogo()
        ]);
        
        return $this->pdo->lastInsertId();
    }

    // Supprime un club
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM clubs WHERE id_club = ?");
        $stmt->execute([$id]);
    }

    // Met à jour un club
    public function update(Club $club) {
        $sql = "UPDATE clubs SET
                nom_club = :nom,
                date_creation = :date,
                description = :desc,
                reseaux_sociaux = :rs,
                logo = :logo
                WHERE id_club = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id' => $club->getId(),
            ':nom' => $club->getNom(),
            ':date' => $club->getDateCreation(),
            ':desc' => $club->getDescription(),
            ':rs' => $club->getReseauxSociaux(),
            ':logo' => $club->getLogo()
        ]);
    }

    // Vérifie l'existence d'un club
    public function exists($id) {
        $stmt = $this->pdo->prepare("SELECT 1 FROM clubs WHERE id_club = ?");
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }
}
?>