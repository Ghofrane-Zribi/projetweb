<!-- C:\xampp\htdocs\projetweb-test\view\frontoffice\clubs_list.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Clubs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h2>Liste des Clubs</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <div class="row">
            <?php foreach ($clubs as $club): ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($club->getNomClub()) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($club->getDescription()) ?></p>
                            <a href="?controller=frontoffice&action=club_details&id_club=<?= $club->getIdClub() ?>" class="btn btn-info">Voir détails</a>
                            <a href="?controller=frontoffice&action=join_club&id_club=<?= $club->getIdClub() ?>" class="btn btn-success">Rejoindre</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>