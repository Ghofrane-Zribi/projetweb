<?php
// C:\xampp\htdocs\projetweb-test\model\manager\EtudiantManager.php
require_once 'model/entite/Etudiant.php';
require_once 'core/Database.php';

class EtudiantManager {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
        if (!$this->pdo) {
            die("DEBUG: Erreur - Connexion PDO non établie.");
        }
    }

    public function create(Etudiant $etudiant) {
        //echo "<pre>DEBUG: Tentative d'ajout d'un étudiant</pre>";
        $stmt = $this->pdo->prepare("
            INSERT INTO etudiants (nom, prenom, email, mot_de_passe, date_naissance, cv) 
            VALUES (:nom, :prenom, :email, :mot_de_passe, :date_naissance, :cv)
        ");
        $mot_de_passe = password_hash($etudiant->getMotDePasse(), PASSWORD_BCRYPT);
        $params = [
            ':nom' => $etudiant->getNom(),
            ':prenom' => $etudiant->getPrenom(),
            ':email' => $etudiant->getEmail(),
            ':mot_de_passe' => $mot_de_passe,
            ':date_naissance' => $etudiant->getDateNaissance(),
            ':cv' => $etudiant->getCv()
        ];
        //echo "<pre>DEBUG: Paramètres d'insertion : "; var_dump($params); echo "</pre>";
        $stmt->execute($params);
        $id = $this->pdo->lastInsertId();
        //echo "<pre>DEBUG: Étudiant créé avec ID : $id</pre>";
        return $id;
    }

    public function findById($id_etudiant) {
        //echo "<pre>DEBUG: Recherche de l'étudiant ID : $id_etudiant</pre>";
        $stmt = $this->pdo->prepare("SELECT * FROM etudiants WHERE id_etudiant = :id");
        $stmt->execute([':id' => $id_etudiant]);
        $data = $stmt->fetch();
        //echo "<pre>DEBUG: Résultat brut pour ID $id_etudiant : "; var_dump($data); echo "</pre>";
        if ($data) {
            return new Etudiant(
                $data->id_etudiant,
                $data->nom,
                $data->prenom,
                $data->email,
                $data->mot_de_passe,
                $data->date_naissance,
                $data->cv
            );
        }
        return null;
    }

    public function findByEmail($email) {
        //echo "<pre>DEBUG: Recherche par email : $email</pre>";
        $stmt = $this->pdo->prepare("SELECT * FROM etudiants WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $data = $stmt->fetch();
        //echo "<pre>DEBUG: Résultat brut pour email $email : "; var_dump($data); echo "</pre>";
        if ($data) {
            return new Etudiant(
                $data->id_etudiant,
                $data->nom,
                $data->prenom,
                $data->email,
                $data->mot_de_passe,
                $data->date_naissance,
                $data->cv
            );
        }
        return null;
    }

    public function findAll() {
        //echo "<pre>DEBUG: Récupération de tous les étudiants</pre>";
        $stmt = $this->pdo->query("SELECT * FROM etudiants");
        $etudiants = [];
        while ($data = $stmt->fetch()) {
            $etudiants[] = new Etudiant(
                $data->id_etudiant,
                $data->nom,
                $data->prenom,
                $data->email,
                $data->mot_de_passe,
                $data->date_naissance,
                $data->cv
            );
        }
        //echo "<pre>DEBUG: Étudiants récupérés : "; var_dump($etudiants); echo "</pre>";
        return $etudiants;
    }

    public function update(Etudiant $etudiant) {
        //echo "<pre>DEBUG: Mise à jour de l'étudiant ID : " . $etudiant->getIdEtudiant() . "</pre>";
        $stmt = $this->pdo->prepare("
            UPDATE etudiants 
            SET nom = :nom, prenom = :prenom, email = :email, mot_de_passe = :mot_de_passe, 
                date_naissance = :date_naissance, cv = :cv 
            WHERE id_etudiant = :id
        ");
        $params = [
            ':id' => $etudiant->getIdEtudiant(),
            ':nom' => $etudiant->getNom(),
            ':prenom' => $etudiant->getPrenom(),
            ':email' => $etudiant->getEmail(),
            ':mot_de_passe' => $etudiant->getMotDePasse(),
            ':date_naissance' => $etudiant->getDateNaissance(),
            ':cv' => $etudiant->getCv()
        ];
        //echo "<pre>DEBUG: Paramètres de mise à jour : "; var_dump($params); echo "</pre>";
        $stmt->execute($params);
        $count = $stmt->rowCount();
        //echo "<pre>DEBUG: Nombre de lignes mises à jour : $count</pre>";
        return $count;
    }

    public function delete($id_etudiant) {
        //echo "<pre>DEBUG: Suppression de l'étudiant ID : $id_etudiant</pre>";
        $stmt = $this->pdo->prepare("DELETE FROM etudiants WHERE id_etudiant = :id");
        $stmt->execute([':id' => $id_etudiant]);
        $count = $stmt->rowCount();
        //echo "<pre>DEBUG: Nombre de lignes supprimées : $count</pre>";
        return $count;
    }
}
?>