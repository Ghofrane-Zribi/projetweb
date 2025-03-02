<?php
require_once '../config.php';

class AdhesionC
{
    public function listAdhesions()
    {
        $sql = "SELECT * FROM adhesions";
        $db = Config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function addAdhesion($adhesion)
    {
        $sql = "INSERT INTO adhesions (IDetudiant, IDclub) VALUES (:IDetudiant, :IDclub)";
        $db = Config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'IDetudiant' => $adhesion->getIDetudiant(),
                'IDclub' => $adhesion->getIDclub(),
            ]);

            echo "Adhésion ajoutée avec succès!";
        } catch (Exception $e) {
            echo 'Erreur lors de l\'ajout de l\'adhésion: ' . $e->getMessage();
        }
    }

    public function deleteAdhesion($IDetudiant, $IDclub)
    {
        $sql = "DELETE FROM adhesions WHERE IDetudiant = :IDetudiant AND IDclub = :IDclub";
        $db = Config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':IDetudiant', $IDetudiant);
        $req->bindValue(':IDclub', $IDclub);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
}
?>
