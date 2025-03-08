<!-- C:\xampp\htdocs\projetweb-test\view\etudiant\list.php -->
<?php if (!isset($_GET['controller']) || !isset($_GET['action'])) {
    header('Location: ../../index.php?controller=etudiant&action=list');
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des étudiants</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Liste des étudiants</h1>
        <a href="?controller=etudiant&action=logout" class="btn btn-danger mb-3">Se déconnecter</a>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (empty($etudiants)): ?>
            <div class="alert alert-info">Aucun étudiant trouvé.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Date de naissance</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($etudiants as $etudiant): ?>
                            <tr>
                                <td><?= htmlspecialchars($etudiant->getIdEtudiant()) ?></td>
                                <td><?= htmlspecialchars($etudiant->getNom()) ?></td>
                                <td><?= htmlspecialchars($etudiant->getPrenom()) ?></td>
                                <td><?= htmlspecialchars($etudiant->getEmail()) ?></td>
                                <td><?= htmlspecialchars($etudiant->getDateNaissance()) ?></td>
                                <td>
                                    <a href="?controller=etudiant&action=edit&id=<?= urlencode($etudiant->getIdEtudiant()) ?>" class="btn btn-primary btn-sm">Modifier</a>
                                    <a href="?controller=etudiant&action=delete&id=<?= urlencode($etudiant->getIdEtudiant()) ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Voulez-vous vraiment supprimer cet étudiant ?');">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <a href="?controller=etudiant&action=create" class="btn btn-success mt-3">Ajouter un étudiant</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>