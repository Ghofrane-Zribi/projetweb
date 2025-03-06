<?php
require_once '../Config.php';

class EtudiantC {
    // Lister tous les étudiants
    public function listEtudiants() {
        $sql = "SELECT * FROM etudiants";
        $db = Config::getConnexion();
        try {
            $liste = $db->query($sql);
            return $liste;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Ajouter un étudiant
    public function addEtudiant($etudiant) {
        $sql = "INSERT INTO etudiants (nom, prenom, email, mot_de_passe, date_naissance, cv, id_club) 
                VALUES (:nom, :prenom, :email, :mot_de_passe, :date_naissance, :cv, :id_club)";
        $db = Config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->execute([
                'nom' => $etudiant->getNom(),
                'prenom' => $etudiant->getPrenom(),
                'email' => $etudiant->getEmail(),
                'mot_de_passe' => $etudiant->getMotDePasse(),
                'date_naissance' => $etudiant->getDateNaissance(),
                'cv' => $etudiant->getCv(),
                'id_club' => $etudiant->getIdClub(),
            ]);

            echo "Étudiant ajouté avec succès!";
        } catch (Exception $e) {
            echo 'Erreur lors de l\'ajout de l\'étudiant: ' . $e->getMessage();
        }
    }

    // Supprimer un étudiant
    public function deleteEtudiant($id_etudiant) {
        $sql = "DELETE FROM etudiants WHERE id_etudiant = :id_etudiant";
        $db = Config::getConnexion();
        $req = $db->prepare($sql);
        $req->bindValue(':id_etudiant', $id_etudiant);

        try {
            $req->execute();
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Afficher un étudiant par son ID
    public function showEtudiant($id_etudiant) {
        $sql = "SELECT * FROM etudiants WHERE id_etudiant = :id_etudiant";
        $db = Config::getConnexion();
        try {
            $query = $db->prepare($sql);
            $query->bindValue(':id_etudiant', $id_etudiant);
            $query->execute();
            $etudiant = $query->fetch();
            return $etudiant;
        } catch (Exception $e) {
            die('Error: ' . $e->getMessage());
        }
    }

    // Mettre à jour un étudiant
    public function updateEtudiant($etudiant, $id_etudiant) {
        try {
            $db = Config::getConnexion();
            $query = $db->prepare(
                'UPDATE etudiants SET 
                    nom = :nom,
                    prenom = :prenom,
                    email = :email,
                    mot_de_passe = :mot_de_passe,
                    date_naissance = :date_naissance,
                    cv = :cv,
                    id_club = :id_club
                WHERE id_etudiant = :id_etudiant'
            );

            $query->execute([
                'id_etudiant' => $id_etudiant,
                'nom' => $etudiant->getNom(),
                'prenom' => $etudiant->getPrenom(),
                'email' => $etudiant->getEmail(),
                'mot_de_passe' => $etudiant->getMotDePasse(),
                'date_naissance' => $etudiant->getDateNaissance(),
                'cv' => $etudiant->getCv(),
                'id_club' => $etudiant->getIdClub(),
            ]);

            echo $query->rowCount() . " enregistrement(s) mis à jour avec succès!";
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }
}
?>