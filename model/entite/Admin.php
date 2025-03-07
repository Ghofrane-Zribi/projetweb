<?php
// model/entite/Admin.php
class Admin {
    private $id_admin;
    private $nom;
    private $email;
    private $password;
    private $created_at;

    public function hydrate(array $data) {
        foreach ($data as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // Getters
    public function getIdAdmin() { return $this->id_admin; }
    public function getNom() { return $this->nom; }
    public function getEmail() { return $this->email; }
    public function getPassword() { return $this->password; }
    public function getCreatedAt() { return $this->created_at; }

    // Setters avec validation
    public function setId_admin($id) { $this->id_admin = (int)$id; }
    
    public function setNom($nom) { 
        $this->nom = htmlspecialchars(trim($nom)); 
    }
    
    public function setEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Email invalide");
        }
        $this->email = $email;
    }
    
    public function setPassword($password) {
        if (strlen($password) < 8) {
            throw new InvalidArgumentException("Le mot de passe doit contenir au moins 8 caractères");
        }
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    }
    
    public function setCreated_at($date) {
        $this->created_at = $date;
    }
}
?>