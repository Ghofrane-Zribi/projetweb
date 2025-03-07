<?php
// model/manager/AdminManager.php
require_once __DIR__ . '/../../core/Database.php';
require_once __DIR__ . '/../entite/Admin.php';

class AdminManager {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function findByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetchObject('Admin');
        return $admin ?: null;
    }

    public function verifyCredentials($email, $password) {
        $admin = $this->findByEmail($email);
        if ($admin && password_verify($password, $admin->getPassword())) {
            return $admin;
        }
        return null;
    }

    public function create(Admin $admin) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO admins (nom, email, password) 
            VALUES (:nom, :email, :password)"
        );
        
        return $stmt->execute([
            ':nom' => $admin->getNom(),
            ':email' => $admin->getEmail(),
            ':password' => $admin->getPassword()
        ]);
    }
}
?>