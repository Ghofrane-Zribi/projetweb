<?php
require_once "../Config.php";

class Etudiant {
    private $id_etudiant;
    private $nom;
    private $prenom;
    private $email;
    private $mot_de_passe;
    private $date_naissance;
    private $cv;
    private $id_club;

    public function __construct($nom, $prenom, $email, $mot_de_passe, $date_naissance, $cv, $id_club = null) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->mot_de_passe = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        $this->date_naissance = $date_naissance;
        $this->cv = $cv;
        $this->id_club = $id_club;
    }

    public function ajouterEtudiant() {
        $pdo = Database::getConnection();
        $sql = "INSERT INTO etudiants (nom, prenom, email, mot_de_passe, date_naissance, cv, id_club) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->nom, $this->prenom, $this->email, $this->mot_de_passe, $this->date_naissance, $this->cv, $this->id_club]);
    }

    public static function getEtudiantByEmail($email) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM etudiants WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
