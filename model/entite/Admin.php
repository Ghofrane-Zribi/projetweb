<?php
// C:\xampp\htdocs\projetweb-test\model\entite\Admin.php
class Admin {
    private $id_admin;
    private $email;
    private $password_hash;
    private $created_at;

    public function __construct($id_admin = null, $email = '', $password_hash = '', $created_at = null) {
        $this->id_admin = $id_admin;
        $this->email = $email;
        $this->password_hash = $password_hash;
        $this->created_at = $created_at;
    }

    // Getters
    public function getIdAdmin() { return $this->id_admin; }
    public function getEmail() { return $this->email; }
    public function getPasswordHash() { return $this->password_hash; }
    public function getCreatedAt() { return $this->created_at; }

    // Setters
    public function setIdAdmin($id_admin) { $this->id_admin = $id_admin; }
    public function setEmail($email) { $this->email = $email; }
    public function setPasswordHash($password_hash) { $this->password_hash = password_hash($password_hash, PASSWORD_BCRYPT); }
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }
}
?>