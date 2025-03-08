<?php
// C:\xampp\htdocs\projetweb-test\model\entite\Adhesion.php
class Adhesion {
    private $id_adhesion;
    private $id_etudiant;
    private $id_club;
    private $date_demande;
    private $statut;

    public function __construct($id_adhesion = null, $id_etudiant = null, $id_club = null, $date_demande = null, $statut = 'en attente') {
        $this->id_adhesion = $id_adhesion;
        $this->id_etudiant = $id_etudiant;
        $this->id_club = $id_club;
        $this->date_demande = $date_demande;
        $this->statut = $statut;
    }

    // Getters
    public function getIdAdhesion() { return $this->id_adhesion; }
    public function getIdEtudiant() { return $this->id_etudiant; }
    public function getIdClub() { return $this->id_club; }
    public function getDateDemande() { return $this->date_demande; }
    public function getStatut() { return $this->statut; }

    // Setters
    public function setIdAdhesion($id_adhesion) { $this->id_adhesion = $id_adhesion; }
    public function setIdEtudiant($id_etudiant) { $this->id_etudiant = $id_etudiant; }
    public function setIdClub($id_club) { $this->id_club = $id_club; }
    public function setDateDemande($date_demande) { $this->date_demande = $date_demande; }
    public function setStatut($statut) { $this->statut = $statut; }
}
?>