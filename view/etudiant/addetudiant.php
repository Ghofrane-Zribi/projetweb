<?php
// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config.php';
require_once '../controller/EtudiantC.php';
require_once '../model/Etudiant.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier que tous les champs obligatoires sont remplis
    if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['mot_de_passe']) && !empty($_POST['date_naissance']) && !empty($_POST['cv'])) {
        // Hacher le mot de passe
        $mot_de_passe_hash = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

        // Récupérer id_club (peut être null)
        $id_club = !empty($_POST['id_club']) ? $_POST['id_club'] : null;

        // Créer un nouvel étudiant
        $etudiant = new Etudiant(
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['email'],
            $mot_de_passe_hash,
            $_POST['date_naissance'],
            $_POST['cv'],
            $id_club
        );

        // Ajouter l'étudiant à la base de données
        $etudiantC = new EtudiantC();
        try {
            if ($etudiantC->addEtudiant($etudiant)) {
                // Rediriger vers la liste des étudiants
                header("Location: listetudiant.php");
                exit();
            } else {
                echo "Erreur lors de l'ajout de l'étudiant.";
            }
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        echo "Tous les champs obligatoires doivent être remplis.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Étudiant</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h2 class="mt-4">Ajouter un Étudiant</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Prénom</label>
            <input type="text" name="prenom" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Mot de passe</label>
            <input type="password" name="mot_de_passe" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Date de Naissance</label>
            <input type="date" name="date_naissance" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>CV (URL)</label>
            <input type="text" name="cv" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>ID du Club (optionnel)</label>
            <input type="number" name="id_club" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Ajouter</button>
        <a href="listetudiant.php" class="btn btn-secondary">Retour</a>
    </form>
</body>
</html>