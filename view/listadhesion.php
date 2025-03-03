<?php
require_once '../config.php';
require_once '../controller/AdhesionC.php';

$adhesionC = new AdhesionC();
$adhesions = $adhesionC->listAdhesions();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Adhésions</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h2 class="mt-4">Liste des Adhésions</h2>
    <a href="addadhesion.php" class="btn btn-primary mb-3">Ajouter une Adhésion</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Adhésion</th>
                <th>ID Étudiant</th>
                <th>ID Club</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($adhesions as $adhesion): ?>
                <tr>
                    <td><?= $adhesion['id_adhesion'] ?></td>
                    <td><?= $adhesion['id_etudiant'] ?></td>
                    <td><?= $adhesion['id_club'] ?></td>
                    <td><?= $adhesion['statut'] ?></td>
                    <td>
                        <a href="editadhesion.php?id=<?= $adhesion['id_adhesion'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                        <a href="deleteadhesion.php?id=<?= $adhesion['id_adhesion'] ?>" class="btn btn-danger btn-sm">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>