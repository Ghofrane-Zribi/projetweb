<?php
require_once '../Config.php';
require_once '../controller/ClubC.php';
require_once '../model/Club.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $club = new Club($_POST['nom_club'], $_POST['date_creation'], $_POST['description'], $_POST['reseaux_sociaux'], $_POST['logo']);
    $clubC = new ClubC();
    $clubC->addClub($club);
    header("Location: listclub.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Club</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h2 class="mt-4">Ajouter un Club</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Nom du Club</label>
            <input type="text" name="nom_club" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Date de Création</label>
            <input type="date" name="date_creation" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label>Réseaux Sociaux</label>
            <input type="text" name="reseaux_sociaux" class="form-control">
        </div>
        <div class="mb-3">
            <label>URL du Logo</label>
            <input type="text" name="logo" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Ajouter</button>
        <a href="listclub.php" class="btn btn-secondary">Retour</a>
    </form>
</body>
</html>
