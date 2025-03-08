<!-- C:\xampp\htdocs\projetweb-test\view\adhesion\list.php -->
<?php if (!isset($_GET['controller']) || !isset($_GET['action'])) {
    header('Location: ../../index.php?controller=adhesion&action=list');
    exit;
} ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des adhésions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Liste des adhésions</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (empty($adhesions)): ?>
            <div class="alert alert-info">Aucune adhésion trouvée.</div>
        <?php else: ?>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Étudiant</th>
                        <th>Club</th>
                        <th>Date de demande</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($adhesions as $adhesion): ?>
                        <tr>
                            <td><?= htmlspecialchars($adhesion->getIdAdhesion()) ?></td>
                            <td>
                                <?php
                                foreach ($etudiants as $etudiant) {
                                    if ($etudiant->getIdEtudiant() == $adhesion->getIdEtudiant()) {
                                        echo htmlspecialchars($etudiant->getNom() . ' ' . $etudiant->getPrenom());
                                        break;
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                foreach ($clubs as $club) {
                                    if ($club->getIdClub() == $adhesion->getIdClub()) {
                                        echo htmlspecialchars($club->getNomClub());
                                        break;
                                    }
                                }
                                ?>
                            </td>
                            <td><?= htmlspecialchars($adhesion->getDateDemande()) ?></td>
                            <td><?= htmlspecialchars($adhesion->getStatut()) ?></td>
                            <td>
                                <a href="?controller=adhesion&action=edit&id=<?= urlencode($adhesion->getIdAdhesion()) ?>" class="btn btn-primary btn-sm">Modifier</a>
                                <a href="?controller=adhesion&action=delete&id=<?= urlencode($adhesion->getIdAdhesion()) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer cette adhésion ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <a href="?controller=adhesion&action=create" class="btn btn-success mt-3">Ajouter une adhésion</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>