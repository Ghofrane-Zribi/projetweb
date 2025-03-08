<?php
// C:\xampp\htdocs\projetweb-test\model\entite\Etudiant.php
class Etudiant {
    private $id_etudiant;
    private $nom;
    private $prenom;
    private $email;
    private $mot_de_passe;
    private $date_naissance;
    private $cv;

    public function __construct($id_etudiant = null, $nom = '', $prenom = '', $email = '', $mot_de_passe = '', $date_naissance = null, $cv = '') {
        $this->id_etudiant = $id_etudiant;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->mot_de_passe = $mot_de_passe;
        $this->date_naissance = $date_naissance;
        $this->cv = $cv;
    }

    // Getters
    public function getIdEtudiant() { return $this->id_etudiant; }
    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getEmail() { return $this->email; }
    public function getMotDePasse() { return $this->mot_de_passe; }
    public function getDateNaissance() { return $this->date_naissance; }
    public function getCv() { return $this->cv; }

    // Setters
    public function setIdEtudiant($id_etudiant) { $this->id_etudiant = $id_etudiant; }
    public function setNom($nom) { $this->nom = $nom; }
    public function setPrenom($prenom) { $this->prenom = $prenom; }
    public function setEmail($email) { $this->email = $email; }
    public function setMotDePasse($mot_de_passe) { $this->mot_de_passe = password_hash($mot_de_passe, PASSWORD_BCRYPT); }
    public function setDateNaissance($date_naissance) { $this->date_naissance = $date_naissance; }
    public function setCv($cv) { $this->cv = $cv; }
}
?>