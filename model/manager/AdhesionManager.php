<?php
// C:\xampp\htdocs\projetweb-test\model\manager\AdhesionManager.php
require_once 'model/entite/Adhesion.php';
require_once 'core/Database.php';

class AdhesionManager {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function create(Adhesion $adhesion) {
        $stmt = $this->pdo->prepare("
            INSERT INTO adhesions (id_etudiant, id_club, date_demande, statut) 
            VALUES (:id_etudiant, :id_club, :date_demande, :statut)
        ");
        $stmt->execute([
            ':id_etudiant' => $adhesion->getIdEtudiant(),
            ':id_club' => $adhesion->getIdClub(),
            ':date_demande' => $adhesion->getDateDemande() ?: date('Y-m-d H:i:s'),
            ':statut' => $adhesion->getStatut()
        ]);
        return $this->pdo->lastInsertId();
    }

    public function findById($id_adhesion) {
        $stmt = $this->pdo->prepare("SELECT * FROM adhesions WHERE id_adhesion = :id");
        $stmt->execute([':id' => $id_adhesion]);
        $data = $stmt->fetch();
        if ($data) {
            return new Adhesion(
                $data->id_adhesion,
                $data->id_etudiant,
                $data->id_club,
                $data->date_demande,
                $data->statut
            );
        }
        return null;
    }

    public function findAll() {
        $stmt = $this->pdo->query("SELECT * FROM adhesions");
        $adhesions = [];
        while ($data = $stmt->fetch()) {
            $adhesions[] = new Adhesion(
                $data->id_adhesion,
                $data->id_etudiant,
                $data->id_club,
                $data->date_demande,
                $data->statut
            );
        }
        return $adhesions;
    }

    public function update(Adhesion $adhesion) {
        $stmt = $this->pdo->prepare("
            UPDATE adhesions 
            SET id_etudiant = :id_etudiant, id_club = :id_club, date_demande = :date_demande, statut = :statut 
            WHERE id_adhesion = :id
        ");
        $stmt->execute([
            ':id' => $adhesion->getIdAdhesion(),
            ':id_etudiant' => $adhesion->getIdEtudiant(),
            ':id_club' => $adhesion->getIdClub(),
            ':date_demande' => $adhesion->getDateDemande(),
            ':statut' => $adhesion->getStatut()
        ]);
        return $stmt->rowCount();
    }

    public function delete($id_adhesion) {
        $stmt = $this->pdo->prepare("DELETE FROM adhesions WHERE id_adhesion = :id");
        $stmt->execute([':id' => $id_adhesion]);
        return $stmt->rowCount();
    }

    public function count() {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM adhesions");
        return $stmt->fetchColumn();
    }
}
?>