<!-- C:\xampp\htdocs\projetweb-test\view\admin\dashboard.php -->
<?php if (!isset($_GET['controller']) || !isset($_GET['action'])) {
    header('Location: ../../index.php?controller=admin&action=dashboard');
    exit;
}
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: ?controller=admin&action=login');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Tableau de bord Administrateur</h1>
        <a href="?controller=admin&action=logout" class="btn btn-danger mb-3">Se déconnecter</a>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- Statistique globale : Nombre total d'étudiants -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Nombre total d'étudiants</h5>
                <p class="card-text"><?= htmlspecialchars($totalEtudiants) ?></p>
            </div>
        </div>

        <!-- Statistiques par club -->
        <h2 class="mb-3">Statistiques par club</h2>
        <?php if (empty($clubs)): ?>
            <div class="alert alert-info">Aucun club trouvé.</div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($clubs as $club): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($club->getNomClub()) ?></h5>
                                <p class="card-text">Nombre d'étudiants inscrits : <?= htmlspecialchars($statsEtudiantsParClub[$club->getIdClub()] ?? 0) ?></p>
                                <p class="card-text">Nombre total de demandes d'adhésion : <?= htmlspecialchars($statsDemandesParClub[$club->getIdClub()] ?? 0) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <a href="?controller=admin&action=list" class="btn btn-secondary mt-3">Retour à la liste des admins</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>