<?php
// C:\xampp\htdocs\projetweb-test\model\entite\Club.php
class Club {
    private $id_club;
    private $nom_club;
    private $date_creation;
    private $description;
    private $reseaux_sociaux;
    private $logo;

    public function __construct($id_club = null, $nom_club = '', $date_creation = null, $description = '', $reseaux_sociaux = '', $logo = '') {
        $this->id_club = $id_club;
        $this->nom_club = $nom_club;
        $this->date_creation = $date_creation;
        $this->description = $description;
        $this->reseaux_sociaux = $reseaux_sociaux;
        $this->logo = $logo;
    }

    // Getters
    public function getIdClub() { return $this->id_club; }
    public function getNomClub() { return $this->nom_club; }
    public function getDateCreation() { return $this->date_creation; }
    public function getDescription() { return $this->description; }
    public function getReseauxSociaux() { return $this->reseaux_sociaux; }
    public function getLogo() { return $this->logo; }

    // Setters
    public function setIdClub($id_club) { $this->id_club = $id_club; }
    public function setNomClub($nom_club) { $this->nom_club = $nom_club; }
    public function setDateCreation($date_creation) { $this->date_creation = $date_creation; }
    public function setDescription($description) { $this->description = $description; }
    public function setReseauxSociaux($reseaux_sociaux) { $this->reseaux_sociaux = $reseaux_sociaux; }
    public function setLogo($logo) { $this->logo = $logo; }
}
?>