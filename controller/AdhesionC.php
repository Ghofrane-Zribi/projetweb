<?php
require_once '../Config.php';

class AdhesionC
{
    public function listAdhesions()
    {
        $sql = "SELECT * FROM adhesions";
        $db = Database::getConnection();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }
    public function showAdhesion($id_adhesion) 
    {
        return Adhesion::getAdhesionById($id_adhesion); 
    }   

    public function addAdhesion($adhesion)
    {
            $db = Database::getConnection();
            $stmt = $db->prepare("SELECT id_etudiant FROM etudiants WHERE id_etudiant = ?");
            $stmt->execute([$adhesion->getIdEtudiant()]);
            
            if (!$stmt->fetch()) {
                die("Erreur : L'étudiant n'existe pas.");
            }
            $stmt2 = $db->prepare("SELECT id_club FROM clubs WHERE id_club = ?");
            $stmt2->execute([$adhesion->getIdClub()]);
            
            if (!$stmt2->fetch()) {
                die("Erreur : Le club n'existe pas.");
            }
        
        
        $sql = "INSERT INTO adhesions (id_etudiant, id_club) VALUES (:id_etudiant, :id_club)";
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id_etudiant' => $adhesion->getIdEtudiant(),
                'id_club' => $adhesion->getIdClub(),
            ]);

            echo "Adhésion ajoutée avec succès!";
        } catch (Exception $e) {
            echo 'Erreur' . $e->getMessage();
            die ();
        }
    }

    public function deleteAdhesion($id_etudiant, $id_club) {
        $sql = "DELETE FROM adhesions WHERE id_etudiant = :id_etudiant AND id_club = :id_club";
        $db = Database::getConnection();
        $req = $db->prepare($sql);
        $req->bindValue(':id_etudiant', $id_etudiant);
        $req->bindValue(':id_club', $id_club);
    
        try {
            $req->execute();
            echo "Adhésion supprimée avec succès !";
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
    public function updateAdhesion($adhesion, $id_adhesion) {
        $sql = "UPDATE adhesions 
                SET id_etudiant = :id_etudiant, 
                    id_club = :id_club, 
                    statut = :statut 
                WHERE id_adhesion = :id_adhesion";
    
        $db = Database::getConnection();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'id_etudiant' => $adhesion->getIdEtudiant(),
                'id_club' => $adhesion->getIdClub(),
                'statut' => $adhesion->getStatut(),
                'id_adhesion' => $id_adhesion
            ]);
            echo "Statut mis à jour avec succès !";
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }
}
?>
