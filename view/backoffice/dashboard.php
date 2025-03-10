<!-- C:\xampp\htdocs\projetweb-test\view\backoffice\dashboard.php -->
<?php if (!isset($_GET['controller']) || !isset($_GET['action'])) {
    header('Location: ../../index.php?controller=backoffice&action=dashboard');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="mb-4">Tableau de bord Administrateur</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- Statistiques globales -->
        <h2 class="mb-3">Statistiques globales</h2>
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nombre total d'étudiants</h5>
                        <p class="card-text"><?= htmlspecialchars($totalEtudiants) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nombre total de clubs</h5>
                        <p class="card-text"><?= htmlspecialchars($totalClubs) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nombre total de demandes d'adhésion</h5>
                        <p class="card-text"><?= htmlspecialchars($totalAdhesions) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Taux d'acceptation global</h5>
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" 
                                 style="width: <?= htmlspecialchars(round($tauxAcceptationGlobal, 2)) ?>%" 
                                 aria-valuenow="<?= htmlspecialchars(round($tauxAcceptationGlobal, 2)) ?>" 
                                 aria-valuemin="0" aria-valuemax="100">
                                <?= htmlspecialchars(round($tauxAcceptationGlobal, 2)) ?>%
                            </div>
                        </div>
                    </div>
                </div>
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
                                <p class="card-text">Taux d'acceptation :
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" 
                                             style="width: <?= htmlspecialchars(round($tauxAcceptationParClub[$club->getIdClub()], 2)) ?>%" 
                                             aria-valuenow="<?= htmlspecialchars(round($tauxAcceptationParClub[$club->getIdClub()], 2)) ?>" 
                                             aria-valuemin="0" aria-valuemax="100">
                                            <?= htmlspecialchars(round($tauxAcceptationParClub[$club->getIdClub()], 2)) ?>%
                                        </div>
                                    </div>
                                </p>
                                
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>