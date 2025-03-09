<?php
// C:\xampp\htdocs\projetweb-test\model\manager\AdminManager.php
require_once 'model/entite/Admin.php';
require_once 'core/Database.php';

class AdminManager {
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getConnection();
    }

    public function create(Admin $admin) {
        $stmt = $this->pdo->prepare("
            INSERT INTO admins (email, password_hash, created_at) 
            VALUES (:email, :password_hash, :created_at)
        ");
        $password_hash = password_hash($admin->getPasswordHash(), PASSWORD_BCRYPT);
        $stmt->execute([
            ':email' => $admin->getEmail(),
            ':password_hash' => $password_hash,
            ':created_at' => $admin->getCreatedAt() ?: date('Y-m-d H:i:s')
        ]);
        return $this->pdo->lastInsertId();
    }

    public function findById($id_admin) {
        $stmt = $this->pdo->prepare("SELECT * FROM admins WHERE id_admin = :id");
        $stmt->execute([':id' => $id_admin]);
        $data = $stmt->fetch();
        if ($data) {
            return new Admin(
                $data->id_admin,
                $data->email,
                $data->password_hash,
                $data->created_at
            );
        }
        return null;
    }

    public function findByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM admins WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $data = $stmt->fetch();
        if ($data) {
            return new Admin(
                $data->id_admin,
                $data->email,
                $data->password_hash,
                $data->created_at
            );
        }
        return null;
    }

    public function findAll() {
        $stmt = $this->pdo->query("SELECT * FROM admins");
        $admins = [];
        while ($data = $stmt->fetch()) {
            $admins[] = new Admin(
                $data->id_admin,
                $data->email,
                $data->password_hash,
                $data->created_at
            );
        }
        return $admins;
    }

    public function update(Admin $admin) {
        $stmt = $this->pdo->prepare("
            UPDATE admins 
            SET email = :email, password_hash = :password_hash, created_at = :created_at 
            WHERE id_admin = :id
        ");
        $stmt->execute([
            ':id' => $admin->getIdAdmin(),
            ':email' => $admin->getEmail(),
            ':password_hash' => $admin->getPasswordHash(),
            ':created_at' => $admin->getCreatedAt()
        ]);
        return $stmt->rowCount();
    }

    public function delete($id_admin) {
        $stmt = $this->pdo->prepare("DELETE FROM admins WHERE id_admin = :id");
        $stmt->execute([':id' => $id_admin]);
        return $stmt->rowCount();
    }

    public function getAdminByEmail($email) {
        $stmt = $this->pdo->prepare("SELECT * FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$admin) {
            error_log("Aucun admin trouvé avec l'email : " . $email);
        }
        return $admin;
    }

    public function login($email, $mot_de_passe) {
        $admin = $this->findByEmail($email);
        if ($admin && password_verify($mot_de_passe, $admin->getPasswordHash())) {
            return $admin;
        }
        error_log("Échec de la connexion pour l'email : " . $email);
        return null;
    }

    public function count() {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM admins");
        return $stmt->fetchColumn();
    }
}
?>