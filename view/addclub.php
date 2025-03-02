<?php
require_once '../config.php';
require_once '../controller/ClubC.php';
require_once '../model/Club.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_club = isset($_POST['nom_club']) ? $_POST['nom_club'] : '';
    $date_creation = isset($_POST['date_creation']) ? $_POST['date_creation'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $reseaux_sociaux = isset($_POST['reseaux_sociaux']) ? $_POST['reseaux_sociaux'] : '';
    $logo = isset($_POST['logo']) ? $_POST['logo'] : '';

    if (!empty($nom_club) && !empty($date_creation) && !empty($description)) {
        $club = new Club($nom_club, $date_creation, $description, $reseaux_sociaux, $logo);
        $clubC = new ClubC();
        $clubC->addClub($club);
        header("Location: listclub.php");
        exit();
    } else {
        echo "<p>Veuillez remplir tous les champs obligatoires !</p>";
    }
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
            <input type="text" name="nom_club" class="form-control" value="<?= isset($nom_club) ? $nom_club : '' ?>" required>
        </div>
        <div class="mb-3">
            <label>Date de Création</label>
            <input type="date" name="date_creation" class="form-control" value="<?= isset($date_creation) ? $date_creation : '' ?>" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required><?= isset($description) ? $description : '' ?></textarea>
        </div>
        <div class="mb-3">
            <label>Réseaux Sociaux</label>
            <input type="text" name="reseaux_sociaux" class="form-control" value="<?= isset($reseaux_sociaux) ? $reseaux_sociaux : '' ?>">
        </div>
        <div class="mb-3">
            <label>URL du Logo</label>
            <input type="text" name="logo" class="form-control" value="<?= isset($logo) ? $logo : '' ?>">
        </div>
        <button type="submit" class="btn btn-success">Ajouter</button>
        <a href="listclub.php" class="btn btn-secondary">Retour</a>
    </form>
</body>
</html>
