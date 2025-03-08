<!-- C:\xampp\htdocs\projetweb-test\view\club\edit.php -->
<?php if (!isset($_GET['controller']) || !isset($_GET['action'])) {
    header('Location: ../../index.php?controller=club&action=list');
    exit;
} ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un club</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Modifier un club</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (isset($club)): ?>
            <form action="?controller=club&action=update&id=<?= urlencode($club->getIdClub()) ?>" method="POST" class="needs-validation" novalidate>
                <div class="mb-3">
                    <label for="nom_club" class="form-label">Nom du club :</label>
                    <input type="text" class="form-control" id="nom_club" name="nom_club" value="<?= htmlspecialchars($club->getNomClub()) ?>" required>
                    <div class="invalid-feedback">Veuillez entrer le nom du club.</div>
                </div>
                <div class="mb-3">
                    <label for="date_creation" class="form-label">Date de création :</label>
                    <input type="date" class="form-control" id="date_creation" name="date_creation" value="<?= htmlspecialchars($club->getDateCreation()) ?>" required>
                    <div class="invalid-feedback">Veuillez entrer une date de création.</div>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description :</label>
                    <textarea class="form-control" id="description" name="description" rows="4"><?= htmlspecialchars($club->getDescription()) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="reseaux_sociaux" class="form-label">Réseaux sociaux :</label>
                    <input type="text" class="form-control" id="reseaux_sociaux" name="reseaux_sociaux" value="<?= htmlspecialchars($club->getReseauxSociaux()) ?>">
                </div>
                <div class="mb-3">
                    <label for="logo" class="form-label">Logo (chemin) :</label>
                    <input type="text" class="form-control" id="logo" name="logo" value="<?= htmlspecialchars($club->getLogo()) ?>">
                </div>
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="?controller=club&action=list" class="btn btn-secondary">Retour</a>
            </form>
        <?php else: ?>
            <div class="alert alert-danger">Club non trouvé.</div>
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