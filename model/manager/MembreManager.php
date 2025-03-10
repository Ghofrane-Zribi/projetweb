<?php
// C:\xampp\htdocs\projetweb-test\model\manager\MembreManager.php
require_once 'model/entite/Membre.php';
require_once 'core/Database.php';

class MembreManager {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function create(Membre $membre) {
        $stmt = $this->pdo->prepare("
            INSERT INTO membres (id_etudiant, id_club, date_inscription, role)
            VALUES (:id_etudiant, :id_club, :date_inscription, :role)
        ");
        $stmt->execute([
            ':id_etudiant' => $membre->getIdEtudiant(),
            ':id_club' => $membre->getIdClub(),
            ':date_inscription' => $membre->getDateInscription() ?: date('Y-m-d'),
            ':role' => $membre->getRole()
        ]);
        return $this->pdo->lastInsertId();
    }

    public function findById($id_membre) {
        $stmt = $this->pdo->prepare("SELECT * FROM membres WHERE id_membre = :id");
        $stmt->execute([':id' => $id_membre]);
        $data = $stmt->fetch();
        if ($data) {
            return new Membre(
                $data->id_membre,
                $data->id_etudiant,
                $data->id_club,
                $data->date_inscription,
                $data->role
            );
        }
        return null;
    }

    public function findByEtudiantAndClub($id_etudiant, $id_club = null) {
        $query = "SELECT * FROM membres WHERE id_etudiant = :id_etudiant";
        $params = [':id_etudiant' => $id_etudiant];
        if ($id_club !== null) {
            $query .= " AND id_club = :id_club";
            $params[':id_club'] = $id_club;
        }
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        $membres = [];
        while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $membres[] = new Membre(
                $data['id_membre'],
                $data['id_etudiant'],
                $data['id_club'],
                $data['date_inscription'],
                $data['role']
            );
        }
        return $membres; // Toujours retourner un tableau
    }

    public function findAll() {
        $stmt = $this->pdo->query("SELECT * FROM membres");
        $membres = [];
        while ($data = $stmt->fetch()) {
            $membres[] = new Membre(
                $data->id_membre,
                $data->id_etudiant,
                $data->id_club,
                $data->date_inscription,
                $data->role
            );
        }
        return $membres;
    }

    public function findByClub($id_club) {
        $stmt = $this->pdo->prepare("SELECT * FROM membres WHERE id_club = :id_club");
        $stmt->execute([':id_club' => $id_club]);
        $membres = [];
        while ($data = $stmt->fetch()) {
            $membres[] = new Membre(
                $data->id_membre,
                $data->id_etudiant,
                $data->id_club,
                $data->date_inscription,
                $data->role
            );
        }
        return $membres;
    }

    public function update(Membre $membre) {
        $stmt = $this->pdo->prepare("
            UPDATE membres 
            SET id_etudiant = :id_etudiant, id_club = :id_club, date_inscription = :date_inscription, role = :role
            WHERE id_membre = :id
        ");
        $stmt->execute([
            ':id' => $membre->getIdMembre(),
            ':id_etudiant' => $membre->getIdEtudiant(),
            ':id_club' => $membre->getIdClub(),
            ':date_inscription' => $membre->getDateInscription(),
            ':role' => $membre->getRole()
        ]);
        return $stmt->rowCount();
    }

    public function delete($id_membre) {
        $stmt = $this->pdo->prepare("DELETE FROM membres WHERE id_membre = :id");
        $stmt->execute([':id' => $id_membre]);
        return $stmt->rowCount();
    }

    public function count() {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM membres");
        return $stmt->fetchColumn();
    }
    // Nouvelle méthode pour compter les membres d’un club
    public function countMembersByClub($id_club) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM membres WHERE id_club = :id_club");
        $stmt->execute([':id_club' => $id_club]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0; // Retourne 0 si aucun membre
    }
}
?>