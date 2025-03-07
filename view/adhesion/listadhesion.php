<?php
require_once __DIR__ . '/../../controller/AdhesionC.php';
require_once __DIR__ . '/../../model/entite/Adhesion.php';
$adhesionController = new AdhesionC();

// Gestion des messages de succès/erreur
$success = $_GET['success'] ?? null;
$error = $_GET['error'] ?? null;
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
    
    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <a href="addadhesion.php" class="btn btn-primary mb-3">Ajouter une Adhésion</a>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Étudiant</th>
                <th>Club</th>
                <th>Statut</th>
                <th>Date demande</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($adhesions as $adhesion): ?>
                <tr>
                    <td><?= htmlspecialchars($adhesion->getIdAdhesion()) ?></td>
                    <td><?= htmlspecialchars($adhesion->getEtudiant()->getNomComplet()) ?></td>
                    <td><?= htmlspecialchars($adhesion->getClub()->getNom()) ?></td>
                    <td>
                        <span class="badge bg-<?= $adhesion->getStatutClass() ?>">
                            <?= htmlspecialchars($adhesion->getStatut()) ?>
                        </span>
                    </td>
                    <td><?= htmlspecialchars($adhesion->getDateDemande()->format('d/m/Y')) ?></td>
                    <td>
                        <a href="editadhesion.php?id=<?= $adhesion->getIdAdhesion() ?>" 
                           class="btn btn-warning btn-sm">
                           Modifier
                        </a>
                        <a href="deleteadhesion.php?id=<?= $adhesion->getIdAdhesion() ?>"
                           onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette adhésion ?')">
                           Supprimer
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>