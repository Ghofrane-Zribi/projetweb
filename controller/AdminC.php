<?php
require_once '../config.php';

class AdminC
{
    public function listAdmins()
    {
        $sql = "SELECT * FROM administrateurs";
        $db = Config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function addAdmin($admin)
    {
        $sql = "INSERT INTO administrateurs (nom, email, mdp, role) 
                VALUES (:nom, :email, :mdp, :role)";
        $db = Config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom' => $admin->getNom(),
                'email' => $admin->getEmail(),
                'mdp' => $admin->getMdp(),
                'role' => $admin->getRole(),
            ]);

            echo "Administrateur ajouté avec succès!";
        } catch (Exception $e) {
            echo 'Erreur lors de l\'ajout de l\'administrateur: ' . $e->getMessage();
        }
    }

    public function deleteAdmin($id_admin)
    {
        $sql = "DELETE FROM administrateurs WHERE id_admin = :id_admin";
        $db = Config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id_admin', $id_admin);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}
?>
