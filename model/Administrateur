<?php
require_once "../Config.php";

class Administrateur {
    private $id_admin;
    private $nom;
    private $email;
    private $mot_de_passe;
    private $role;

    public function __construct($nom, $email, $mot_de_passe, $role = "moderateur") {
        $this->nom = $nom;
        $this->email = $email;
        $this->mot_de_passe = password_hash($mot_de_passe, PASSWORD_DEFAULT);
        $this->role = $role;
    }

    public function ajouterAdmin() {
        $pdo = Database::getConnection();
        $sql = "INSERT INTO administrateurs (nom, email, mot_de_passe, role) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$this->nom, $this->email, $this->mot_de_passe, $this->role]);
    }

    public static function getAdminByEmail($email) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM administrateurs WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>