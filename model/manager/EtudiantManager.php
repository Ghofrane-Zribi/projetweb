<?php
require_once __DIR__ . '/../../core/Database.php';
require_once __DIR__ . '/../entite/Etudiant.php';

class EtudiantManager {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    // Création d'un étudiant
    public function create(Etudiant $etudiant) {
        if ($this->findByEmail($etudiant->getEmail())) {
            throw new Exception("Cet email est déjà utilisé");
        }

        $sql = "INSERT INTO etudiants 
                (nom, prenom, email, mot_de_passe, date_naissance, cv, id_club) 
                VALUES 
                (:nom, :prenom, :email, :mdp, :date_naissance, :cv, :id_club)";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nom' => $etudiant->getNom(),
            ':prenom' => $etudiant->getPrenom(),
            ':email' => $etudiant->getEmail(),
            ':mdp' => password_hash($etudiant->getMotDePasse(), PASSWORD_BCRYPT),
            ':date_naissance' => $etudiant->getDateNaissance(),
            ':cv' => $etudiant->getCv(),
            ':id_club' => $etudiant->getIdClub()
        ]);
        
        return $this->pdo->lastInsertId();
    }

    // Récupérer un étudiant par ID
    public function find(int $id): ?Etudiant {
        $stmt = $this->pdo->prepare("SELECT * FROM etudiants WHERE id_etudiant = ?");
        $stmt->execute([$id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Etudiant');
        return $stmt->fetch() ?: null;
    }

    // Mettre à jour un étudiant
    public function update(Etudiant $etudiant): bool {
        $sql = "UPDATE etudiants SET 
                nom = :nom,
                prenom = :prenom,
                email = :email,
                mot_de_passe = :mdp,
                date_naissance = :date_naissance,
                cv = :cv,
                id_club = :id_club
                WHERE id_etudiant = :id";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $etudiant->getId(),
            ':nom' => $etudiant->getNom(),
            ':prenom' => $etudiant->getPrenom(),
            ':email' => $etudiant->getEmail(),
            ':mdp' => password_hash($etudiant->getMotDePasse(), PASSWORD_BCRYPT),
            ':date_naissance' => $etudiant->getDateNaissance(),
            ':cv' => $etudiant->getCv(),
            ':id_club' => $etudiant->getIdClub()
        ]);
    }

    // Supprimer un étudiant
    public function delete(int $id): bool {
        $stmt = $this->pdo->prepare("DELETE FROM etudiants WHERE id_etudiant = ?");
        return $stmt->execute([$id]);
    }

    // Trouver par email
    public function findByEmail(string $email): ?Etudiant {
        $stmt = $this->pdo->prepare("SELECT * FROM etudiants WHERE email = ?");
        $stmt->execute([$email]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Etudiant');
        return $stmt->fetch() ?: null;
    }

    // Lister tous les étudiants
    public function findAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM etudiants");
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Etudiant');
    }

    // Vérifier l'existence d'un étudiant
    public function exists(int $id): bool {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM etudiants WHERE id_etudiant = ?");
        $stmt->execute([$id]);
        return (bool)$stmt->fetchColumn();
    }

    // Méthode bonus : Trouver les étudiants d'un club
    public function findByClub(int $clubId): array {
        $stmt = $this->pdo->prepare("SELECT * FROM etudiants WHERE id_club = ?");
        $stmt->execute([$clubId]);
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Etudiant');
    }
}
?>