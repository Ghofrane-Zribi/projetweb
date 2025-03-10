<!-- C:\xampp\htdocs\projetweb-test\view\backoffice\membre_list.php -->
<?php if (!isset($_GET['controller']) || !isset($_GET['action'])) {
    header('Location: ../../index.php?controller=backoffice&action=membreList');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des membres</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="mb-4">Liste des membres</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (empty($membres)): ?>
            <div class="alert alert-info">Aucun membre trouvé.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Étudiant</th>
                            <th>Club</th>
                            <th>Date d'inscription</th>
                            <th>Rôle</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($membres as $membre): ?>
                            <?php
                            $etudiant = array_filter($etudiants, fn($e) => $e->getIdEtudiant() == $membre->getIdEtudiant());
                            $etudiant = reset($etudiant);
                            $club = array_filter($clubs, fn($c) => $c->getIdClub() == $membre->getIdClub());
                            $club = reset($club);
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($membre->getIdMembre()) ?></td>
                                <td><?= htmlspecialchars($etudiant ? $etudiant->getNom() . ' ' . $etudiant->getPrenom() : 'Inconnu') ?></td>
                                <td><?= htmlspecialchars($club ? $club->getNomClub() : 'Inconnu') ?></td>
                                <td><?= htmlspecialchars($membre->getDateInscription()) ?></td>
                                <td><?= htmlspecialchars($membre->getRole()) ?></td>
                                <td>
                                    <a href="?controller=backoffice&action=membreEdit&id=<?= urlencode($membre->getIdMembre()) ?>" class="btn btn-primary btn-sm">Modifier</a>
                                    <a href="?controller=backoffice&action=membreDelete&id=<?= urlencode($membre->getIdMembre()) ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Voulez-vous vraiment supprimer ce membre ?');">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <a href="?controller=backoffice&action=membreCreate" class="btn btn-success mt-3">Ajouter un membre</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>