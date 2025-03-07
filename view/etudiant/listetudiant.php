<?php
require_once '../Config.php';
require_once '../controller/EtudiantC.php';

$etudiantC = new EtudiantC();
$etudiants = $etudiantC->listEtudiants();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Étudiants</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h2 class="mt-4">Liste des Étudiants</h2>
    <a href="addetudiant.php" class="btn btn-primary mb-3">Ajouter un Étudiant</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Date de Naissance</th>
                <th>CV</th>
                <th>Club</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($etudiants as $etudiant): ?>
                <tr>
                    <td><?= $etudiant['id_etudiant'] ?></td>
                    <td><?= $etudiant['nom'] ?></td>
                    <td><?= $etudiant['prenom'] ?></td>
                    <td><?= $etudiant['email'] ?></td>
                    <td><?= $etudiant['date_naissance'] ?></td>
                    <td><a href="<?= $etudiant['cv'] ?>" target="_blank">Voir le CV</a></td>
                    <td><?= $etudiant['id_club'] ?? 'Aucun club' ?></td>
                    <td>
                        <a href="editetudiant.php?id=<?= $etudiant['id_etudiant'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                        <a href="deleteetudiant.php?id=<?= $etudiant['id_etudiant'] ?>" class="btn btn-danger btn-sm">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>