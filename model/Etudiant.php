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
    private $date_inscription;

    // Constructeur
    public function __construct($nom, $prenom, $email, $mot_de_passe, $date_naissance, $cv, $id_club = null) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->mot_de_passe = $mot_de_passe;
        $this->date_naissance = $date_naissance;
        $this->cv = $cv;
        $this->id_club = $id_club;
    }

    // Getters
    public function getIdEtudiant() {
        return $this->id_etudiant;
    }

    public function getNom() {
        return $this->nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getMotDePasse() {
        return $this->mot_de_passe;
    }

    public function getDateNaissance() {
        return $this->date_naissance;
    }

    public function getCv() {
        return $this->cv;
    }

    public function getIdClub() {
        return $this->id_club;
    }

    public function getDateInscription() {
        return $this->date_inscription;
    }

    // Méthode pour ajouter un étudiant
    public function ajouterEtudiant() {
        $pdo = Database::getConnection();
        $sql = "INSERT INTO etudiants (nom, prenom, email, mot_de_passe, date_naissance, cv, id_club) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->nom, $this->prenom, $this->email, $this->mot_de_passe, $this->date_naissance, $this->cv, $this->id_club]);
    }

    // Méthode pour récupérer tous les étudiants
    public static function getAllEtudiants() {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM etudiants");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>