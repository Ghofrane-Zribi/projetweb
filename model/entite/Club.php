<?php
require_once __DIR__ . '/../../core/Database.php';

class Club {
    private $id;
    private $nom;
    private $dateCreation;
    private $description;
    private $reseauxSociaux;
    private $logo;

    // Hydratation depuis un tableau
    public function hydrate(array $data) {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getDateCreation() { return $this->dateCreation; }
    public function getDescription() { return $this->description; }
    public function getReseauxSociaux() { return $this->reseauxSociaux; }
    public function getLogo() { return $this->logo; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setNom($nom) { $this->nom = $nom; }
    public function setDateCreation($date) { $this->dateCreation = $date; }
    public function setDescription($desc) { $this->description = $desc; }
    public function setReseauxSociaux($rs) { $this->reseauxSociaux = $rs; }
    public function setLogo($logo) { $this->logo = $logo; }
}
?>