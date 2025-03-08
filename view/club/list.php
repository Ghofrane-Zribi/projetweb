<!-- C:\xampp\htdocs\projetweb-test\view\club\list.php -->
<?php if (!isset($_GET['controller']) || !isset($_GET['action'])) {
    header('Location: ../../index.php?controller=club&action=list');
    exit;
} ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des clubs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Liste des clubs</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (empty($clubs)): ?>
            <div class="alert alert-info">Aucun club trouvé.</div>
        <?php else: ?>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nom du club</th>
                        <th>Date de création</th>
                        <th>Description</th>
                        <th>Réseaux sociaux</th>
                        <th>Logo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clubs as $club): ?>
                        <tr>
                            <td><?= htmlspecialchars($club->getIdClub()) ?></td>
                            <td><?= htmlspecialchars($club->getNomClub()) ?></td>
                            <td><?= htmlspecialchars($club->getDateCreation()) ?></td>
                            <td><?= htmlspecialchars($club->getDescription()) ?></td>
                            <td><?= htmlspecialchars($club->getReseauxSociaux()) ?></td>
                            <td><?= htmlspecialchars($club->getLogo()) ?></td>
                            <td>
                                <a href="?controller=club&action=edit&id=<?= urlencode($club->getIdClub()) ?>" class="btn btn-primary btn-sm">Modifier</a>
                                <a href="?controller=club&action=delete&id=<?= urlencode($club->getIdClub()) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer ce club ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <a href="?controller=club&action=create" class="btn btn-success mt-3">Ajouter un club</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>