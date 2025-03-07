<?php
require_once __DIR__ . '/../../core/Database.php';

class Etudiant {
    private $id;
    private $nom;
    private $prenom;
    private $email;
    private $mot_de_passe;
    private $date_naissance;
    private $cv;
    private $id_club;
    private $date_inscription;

    public function hydrate(array $data) {
        foreach ($data as $key => $value) {
            $key = str_replace('_', '', ucwords($key, '_'));
            $method = 'set' . ucfirst($key);
            
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getNomComplet() { return $this->prenom . ' ' . $this->nom; }
    public function getEmail() { return $this->email; }
    public function getMotDePasse() { return $this->mot_de_passe; }
    public function getDateNaissance() { return $this->date_naissance; }
    public function getCv() { return $this->cv; }
    public function getIdClub() { return $this->id_club; }
    public function getDateInscription() { return $this->date_inscription; }

    /* Setters

    public function setId($id) { $this->id = $id; }
    public function setNom($nom) { 
        $this->nom = htmlspecialchars(trim($nom)); // Anti-XSS
    }

    public function setPrenom($prenom) { 
        $this->prenom = htmlspecialchars(trim($prenom)); // Anti-XSS
    }

    public function setDateNaissance($date) { 
        if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $date)) {
            throw new InvalidArgumentException("Format de date invalide (AAAA-MM-JJ)");
        }
        $this->date_naissance = $date;
    }
}
    public function setEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email invalide");
        }
        $this->email = $email;
    } 
    public function setIdClub($id_club) {
        $this->id_club = $id_club;
    }   
    public function setMotDePasse($mdp) { $this->mot_de_passe = $mdp; }
    public function setCv($cv) { $this->cv = $cv; }
    public function setDateInscription($date) { $this->date_inscription = $date; }
?> */ 
public function setId($id) { $this->id = $id; }
    public function setNom($nom) { $this->nom = $nom; }
    public function setPrenom($prenom) { $this->prenom = $prenom; }
    
    public function setEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email invalide");
        }
        $this->email = $email;
    }

    public function setIdClub($id_club) { $this->id_club = $id_club; }  // <-- LIGNE 56 CORRIGÉE
    public function setMotDePasse($mdp) { $this->mot_de_passe = $mdp; }
    public function setDateNaissance($date) { $this->date_naissance = $date; }
    public function setCv($cv) { $this->cv = $cv; }
    public function setDateInscription($date) { $this->date_inscription = $date; }
}