<?php
require_once '../config.php';
require_once '../controller/AdminC.php';

$adminC = new AdminC();
$admins = $adminC->listAdmins();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Administrateurs</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h2 class="mt-4">Liste des Administrateurs</h2>
    <a href="addadherent.php" class="btn btn-primary mb-3">Ajouter un Administrateur</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($admins as $admin): ?>
                <tr>
                    <td><?= $admin['id_admin'] ?></td>
                    <td><?= $admin['nom'] ?></td>
                    <td><?= $admin['email'] ?></td>
                    <td><?= $admin['role'] ?></td>
                    <td>
                        <a href="editadherent.php?id=<?= $admin['id_admin'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                        <a href="deleteadherent.php?id=<?= $admin['id_admin'] ?>" class="btn btn-danger btn-sm">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>