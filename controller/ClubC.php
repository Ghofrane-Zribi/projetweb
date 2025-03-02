<?php
require_once '../config.php';

class ClubC
{
    public function listClubs()
    {
        $sql = "SELECT * FROM clubs";
        $db = Config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function addClub($club)
    {
        $sql = "INSERT INTO clubs (nom_club, date_creation, description, reseaux_sociaux, logo) 
                VALUES (:nom_club, :date_creation, :description, :reseaux_sociaux, :logo)";
        $db = Config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom_club' => $club->getNomClub(),
                'date_creation' => $club->getDateCreation(),
                'description' => $club->getDescription(),
                'reseaux_sociaux' => $club->getReseauxSociaux(),
                'logo' => $club->getLogo(),
            ]);

            echo "Club ajouté avec succès!";
        } catch (Exception $e) {
            echo 'Erreur lors de l\'ajout du club: ' . $e->getMessage();
        }
    }

    public function deleteClub($id_club)
    {
        $sql = "DELETE FROM clubs WHERE id_club = :id_club";
        $db = Config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id_club', $id_club);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function showClub($id_club)
    {
        $sql = "SELECT * FROM clubs WHERE id_club = :id_club";
        $db = Config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id_club', $id_club);
            $query->execute();
            $club = $query->fetch();
            return $club;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    public function updateClub($club, $id_club)
    {
        try {
            $db = Config::getConnexion();
            $query = $db->prepare(
                'UPDATE clubs SET 
                    nom_club = :nom_club,
                    date_creation = :date_creation,
                    description = :description,
                    reseaux_sociaux = :reseaux_sociaux,
                    logo = :logo
                WHERE id_club = :id_club'
            );

            $query->execute([
                'id_club' => $id_club,
                'nom_club' => $club->getNomClub(),
                'date_creation' => $club->getDateCreation(),
                'description' => $club->getDescription(),
                'reseaux_sociaux' => $club->getReseauxSociaux(),
                'logo' => $club->getLogo(),
            ]);

            echo $query->rowCount() . " records UPDATED successfully <br>";
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
?>
