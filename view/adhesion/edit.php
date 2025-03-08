<!-- C:\xampp\htdocs\projetweb-test\view\adhesion\edit.php -->
<?php if (!isset($_GET['controller']) || !isset($_GET['action'])) {
    header('Location: ../../index.php?controller=adhesion&action=list');
    exit;
} ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier une adhésion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Modifier une adhésion</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (isset($adhesion)): ?>
            <form action="?controller=adhesion&action=update&id=<?= urlencode($adhesion->getIdAdhesion()) ?>" method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="id_etudiant" class="form-label">Étudiant :</label>
                    <select class="form-control" id="id_etudiant" name="id_etudiant" required>
                        <option value="">Sélectionnez un étudiant</option>
                        <?php foreach ($etudiants as $etudiant): ?>
                            <option value="<?= $etudiant->getIdEtudiant() ?>" <?= $etudiant->getIdEtudiant() == $adhesion->getIdEtudiant() ? 'selected' : '' ?>>
                                <?= htmlspecialchars($etudiant->getNom() . ' ' . $etudiant->getPrenom()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Veuillez sélectionner un étudiant.</div>
                </div>
                <div class="mb-3">
                    <label for="id_club" class="form-label">Club :</label>
                    <select class="form-control" id="id_club" name="id_club" required>
                        <option value="">Sélectionnez un club</option>
                        <?php foreach ($clubs as $club): ?>
                            <option value="<?= $club->getIdClub() ?>" <?= $club->getIdClub() == $adhesion->getIdClub() ? 'selected' : '' ?>>
                                <?= htmlspecialchars($club->getNomClub()) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Veuillez sélectionner un club.</div>
                </div>
                <div class="mb-3">
                    <label for="statut" class="form-label">Statut :</label>
                    <select class="form-control" id="statut" name="statut" required>
                        <option value="en attente" <?= $adhesion->getStatut() == 'en attente' ? 'selected' : '' ?>>En attente</option>
                        <option value="accepté" <?= $adhesion->getStatut() == 'accepté' ? 'selected' : '' ?>>Accepté</option>
                        <option value="refusé" <?= $adhesion->getStatut() == 'refusé' ? 'selected' : '' ?>>Refusé</option>
                    </select>
                    <div class="invalid-feedback">Veuillez sélectionner un statut.</div>
                </div>
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="?controller=adhesion&action=list" class="btn btn-secondary">Retour</a>
            </form>
        <?php else: ?>
            <div class="alert alert-danger">Adhésion non trouvée.</div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>
</html>