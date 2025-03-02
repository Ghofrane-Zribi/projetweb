<?php
require_once '../config.php';
require_once '../controller/ClubC.php';

$clubC = new ClubC();
$clubs = $clubC->listClubs();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Clubs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h2 class="mt-4">Liste des Clubs</h2>
    <a href="addclub.php" class="btn btn-primary mb-3">Ajouter un Club</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Date de création</th>
                <th>Description</th>
                <th>Réseaux</th>
                <th>Logo</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clubs as $club): ?>
                <tr>
                    <td><?= $club['id_club'] ?></td>
                    <td><?= $club['nom_club'] ?></td>
                    <td><?= $club['date_creation'] ?></td>
                    <td><?= $club['description'] ?></td>
                    <td><?= $club['reseaux_sociaux'] ?></td>
                    <td><img src="<?= $club['logo'] ?>" alt="Logo" width="50"></td>
                    <td>
                        <a href="editclub.php?id=<?= $club['id_club'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                        <a href="deleteclub.php?id=<?= $club['id_club'] ?>" class="btn btn-danger btn-sm">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
