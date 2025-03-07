<?php
require_once __DIR__ . '/../entite/Adhesion.php'; 
// Si nécessaire
class Adhesion {
    private $id_adhesion;
    private $id_etudiant;
    private $id_club;
    private $statut;
    private $date_demande; // Ajout recommandé

    // Hydratation depuis un tableau
    public function hydrate(array $data) {
        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // Getters
    public function getStatutClass() {
        return match($this->statut) {
            'accepté' => 'success',
            'refusé' => 'danger',
            default => 'warning'
        };
    }
    
    public function getDateDemande() {
        return new DateTime($this->date_demande);
    }
    public function getIdAdhesion() { return $this->id_adhesion; }
    public function getIdEtudiant() { return $this->id_etudiant; }
    public function getIdClub() { return $this->id_club; }
    public function getStatut() { return $this->statut; }
   
    // Setters
    public function setIdAdhesion($id) { $this->id_adhesion = $id; }
    public function setIdEtudiant($id) { $this->id_etudiant = $id; }
    public function setIdClub($id) { $this->id_club = $id; }
    public function setStatut($statut) { $this->statut = $statut; }
    public function setDateDemande($date) { $this->date_demande = $date; }
}
?>