<?php
require_once '../config.php';
require_once '../controller/ClubC.php';
require_once '../model/Club.php';

$clubC = new ClubC();

if (!isset($_GET['id'])) {
    header("Location: listclub.php");
    exit();
}

$club = $clubC->showClub($_GET['id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $updatedClub = new Club($_POST['nom_club'], $_POST['date_creation'], $_POST['description'], $_POST['reseaux_sociaux'], $_POST['logo']);
    $clubC->updateClub($updatedClub, $_GET['id']);
    header("Location: listclub.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Club</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h2 class="mt-4">Modifier le Club</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Nom du Club</label>
            <input type="text" name="nom_club" class="form-control" value="<?= $club['nom_club'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Date de Création</label>
            <input type="date" name="date_creation" class="form-control" value="<?= $club['date_creation'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required><?= $club['description'] ?></textarea>
        </div>
        <div class="mb-3">
            <label>Réseaux Sociaux</label>
            <input type="text" name="reseaux_sociaux" class="form-control" value="<?= $club['reseaux_sociaux'] ?>">
        </div>
        <div class="mb-3">
            <label>URL du Logo</label>
            <input type="text" name="logo" class="form-control" value="<?= $club['logo'] ?>">
        </div>
        <button type="submit" class="btn btn-warning">Modifier</button>
        <a href="listclub.php" class="btn btn-secondary">Retour</a>
    </form>
</body>
</html>
