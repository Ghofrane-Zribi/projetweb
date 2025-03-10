<!-- C:\xampp\htdocs\projetweb-test\view\frontoffice\club_details.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du Club</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h2>Détails du Club</h2>
        <?php if ($club): ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($club->getNomClub()) ?></h5>
                    <p class="card-text"><strong>Date de création :</strong> <?= htmlspecialchars($club->getDateCreation()) ?></p>
                    <p class="card-text"><strong>Description :</strong> <?= htmlspecialchars($club->getDescription()) ?></p>
                    <p class="card-text"><strong>Réseaux sociaux :</strong> <?= htmlspecialchars($club->getReseauxSociaux()) ?></p>
                    <p class="card-text"><strong>Logo :</strong> <?= htmlspecialchars($club->getLogo()) ?: 'Aucun logo' ?></p>
                    <p class="card-text"><strong>Nombre de membres :</strong> <?= htmlspecialchars($nombre_membres) ?></p> <!-- Ajout -->
                    <a href="?controller=frontoffice&action=clubs_list" class="btn btn-secondary">Retour</a>
                    <a href="?controller=frontoffice&action=join_club&id_club=<?= $club->getIdClub() ?>" class="btn btn-success">Rejoindre</a>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-danger">Club non trouvé.</div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>