<?php
// C:\xampp\htdocs\projetweb-test\model\entite\Membre.php
class Membre {
    private $id_membre;
    private $id_etudiant;
    private $id_club;
    private $date_inscription;
    private $role;

    public function __construct($id_membre = null, $id_etudiant = null, $id_club = null, $date_inscription = null, $role = 'membre') {
        $this->id_membre = $id_membre;
        $this->id_etudiant = $id_etudiant;
        $this->id_club = $id_club;
        $this->date_inscription = $date_inscription;
        $this->role = $role;
    }

    // Getters
    public function getIdMembre() { return $this->id_membre; }
    public function getIdEtudiant() { return $this->id_etudiant; }
    public function getIdClub() { return $this->id_club; }
    public function getDateInscription() { return $this->date_inscription; }
    public function getRole() { return $this->role; }

    // Setters
    public function setIdMembre($id_membre) { $this->id_membre = $id_membre; }
    public function setIdEtudiant($id_etudiant) { $this->id_etudiant = $id_etudiant; }
    public function setIdClub($id_club) { $this->id_club = $id_club; }
    public function setDateInscription($date_inscription) { $this->date_inscription = $date_inscription; }
    public function setRole($role) { $this->role = $role; }
}
?>