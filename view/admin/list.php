<!-- C:\xampp\htdocs\projetweb-test\view\admin\list.php -->
<?php if (!isset($_GET['controller']) || !isset($_GET['action'])) {
    header('Location: ../../index.php?controller=admin&action=list');
    exit;
} ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des admins</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Liste des admins</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (empty($admins)): ?>
            <div class="alert alert-info">Aucun admin trouvé.</div>
        <?php else: ?>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Date de création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $admin): ?>
                        <tr>
                            <td><?= htmlspecialchars($admin->getIdAdmin()) ?></td>
                            <td><?= htmlspecialchars($admin->getEmail()) ?></td>
                            <td><?= htmlspecialchars($admin->getCreatedAt()) ?></td>
                            <td>
                                <a href="?controller=admin&action=edit&id=<?= urlencode($admin->getIdAdmin()) ?>" class="btn btn-primary btn-sm">Modifier</a>
                                <a href="?controller=admin&action=delete&id=<?= urlencode($admin->getIdAdmin()) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Voulez-vous vraiment supprimer cet admin ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <a href="?controller=admin&action=create" class="btn btn-success mt-3">Ajouter un admin</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>