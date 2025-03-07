<?php
require_once __DIR__ . '/../../core/Database.php';
require_once __DIR__ . '/../entite/Adhesion.php';

class AdhesionManager {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    // Crée une adhésion
    public function create(Adhesion $adhesion) {
        $sql = "INSERT INTO adhesions (id_etudiant, id_club, statut) 
                VALUES (:etudiant, :club, :statut)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':etudiant' => $adhesion->getIdEtudiant(),
            ':club' => $adhesion->getIdClub(),
            ':statut' => $adhesion->getStatut()
        ]);
        
        return $this->pdo->lastInsertId();
    }

    // Récupère toutes les adhésions
    public function findAll() {
        $stmt = $this->pdo->query("SELECT * FROM adhesions");
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Adhesion');
    }
    // Dans AdhesionManager.php
public function findAllWithDetails() {
    $stmt = $this->pdo->query("
        SELECT a.*, e.nom AS etudiant_nom, e.prenom, c.nom AS club_nom 
        FROM adhesions a
        LEFT JOIN etudiants e ON a.id_etudiant = e.id_etudiant
        LEFT JOIN clubs c ON a.id_club = c.id_club
    ");
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    // Met à jour une adhésion
    public function update(Adhesion $adhesion) {
        $sql = "UPDATE adhesions SET 
                id_etudiant = :etudiant, 
                id_club = :club, 
                statut = :statut 
                WHERE id_adhesion = :id";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':etudiant' => $adhesion->getIdEtudiant(),
            ':club' => $adhesion->getIdClub(),
            ':statut' => $adhesion->getStatut(),
            ':id' => $adhesion->getIdAdhesion()
        ]);
    }

    // Supprime une adhésion
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM adhesions WHERE id_adhesion = ?");
        $stmt->execute([$id]);
    }
}
?>