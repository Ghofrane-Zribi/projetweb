<?php
// C:\xampp\htdocs\projetweb-test\model\manager\ClubManager.php
require_once 'model/entite/Club.php';
require_once 'core/Database.php';

class ClubManager {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function create(Club $club) {
        $stmt = $this->pdo->prepare("
            INSERT INTO clubs (nom_club, date_creation, description, reseaux_sociaux, logo) 
            VALUES (:nom_club, :date_creation, :description, :reseaux_sociaux, :logo)
        ");
        $stmt->execute([
            ':nom_club' => $club->getNomClub(),
            ':date_creation' => $club->getDateCreation(),
            ':description' => $club->getDescription(),
            ':reseaux_sociaux' => $club->getReseauxSociaux(),
            ':logo' => $club->getLogo()
        ]);
        return $this->pdo->lastInsertId();
    }

    public function findById($id_club) {
        $stmt = $this->pdo->prepare("SELECT * FROM clubs WHERE id_club = :id");
        $stmt->execute([':id' => $id_club]);
        $data = $stmt->fetch();
        if ($data) {
            return new Club(
                $data->id_club,
                $data->nom_club,
                $data->date_creation,
                $data->description,
                $data->reseaux_sociaux,
                $data->logo
            );
        }
        return null;
    }

    public function findByNomClub($nom_club) {
        $stmt = $this->pdo->prepare("SELECT * FROM clubs WHERE nom_club = :nom_club");
        $stmt->execute([':nom_club' => $nom_club]);
        $data = $stmt->fetch();
        if ($data) {
            return new Club(
                $data->id_club,
                $data->nom_club,
                $data->date_creation,
                $data->description,
                $data->reseaux_sociaux,
                $data->logo
            );
        }
        return null;
    }

    public function findAll() {
        $stmt = $this->pdo->query("SELECT * FROM clubs");
        $clubs = [];
        while ($data = $stmt->fetch()) {
            $clubs[] = new Club(
                $data->id_club,
                $data->nom_club,
                $data->date_creation,
                $data->description,
                $data->reseaux_sociaux,
                $data->logo
            );
        }
        return $clubs;
    }

    public function update(Club $club) {
        $stmt = $this->pdo->prepare("
            UPDATE clubs 
            SET nom_club = :nom_club, date_creation = :date_creation, description = :description, 
                reseaux_sociaux = :reseaux_sociaux, logo = :logo 
            WHERE id_club = :id
        ");
        $stmt->execute([
            ':id' => $club->getIdClub(),
            ':nom_club' => $club->getNomClub(),
            ':date_creation' => $club->getDateCreation(),
            ':description' => $club->getDescription(),
            ':reseaux_sociaux' => $club->getReseauxSociaux(),
            ':logo' => $club->getLogo()
        ]);
        return $stmt->rowCount();
    }

    public function delete($id_club) {
        $stmt = $this->pdo->prepare("DELETE FROM clubs WHERE id_club = :id");
        $stmt->execute([':id' => $id_club]);
        return $stmt->rowCount();
    }
}
?>