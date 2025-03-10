<!-- C:\xampp\htdocs\projetweb-test\view\frontoffice\my_clubs.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Clubs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <!-- Section des clubs dont l'étudiant est membre -->
        <h2>Mes Clubs</h2>
        <?php if (empty($clubs)): ?>
            <div class="alert alert-info">Vous n'êtes membre d'aucun club.</div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($clubs as $club): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($club->getNomClub()) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($club->getDescription()) ?></p>
                                <a href="?controller=frontoffice&action=club_details&id_club=<?= $club->getIdClub() ?>" class="btn btn-info">Voir détails</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Section des demandes d'adhésion -->
        <h2 class="mt-5">Mes Demandes d'Adhésion</h2>
        <?php if (empty($adhesions)): ?>
            <div class="alert alert-info">Vous n'avez aucune demande d'adhésion en cours.</div>
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Club</th>
                        <th>Date de la demande</th>
                        <th>État</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($adhesions as $adhesion): ?>
                        <tr>
                            <td><?= htmlspecialchars($adhesion->nom_club) ?></td>
                            <td><?= htmlspecialchars($adhesion->getDateDemande()) ?></td>
                            <td>
                                <?php
                                $statut = htmlspecialchars($adhesion->getStatut());
                                $badge_class = match ($statut) {
                                    'en attente' => 'badge bg-warning',
                                    'acceptée' => 'badge bg-success',
                                    'refusée' => 'badge bg-danger',
                                    default => 'badge bg-secondary',
                                };
                                ?>
                                <span class="<?= $badge_class ?>"><?= $statut ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>