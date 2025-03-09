<!-- C:\xampp\htdocs\projetweb-test\view\backoffice\club_edit.php -->
<?php if (!isset($_GET['controller']) || !isset($_GET['action'])) {
    header('Location: ../../index.php?controller=backoffice&action=clubList');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un club</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="mb-4">Modifier un club</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="?controller=backoffice&action=clubEdit&id=<?= urlencode($club->getIdClub()) ?>" method="POST" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="nom_club" class="form-label">Nom du club :</label>
                <input type="text" class="form-control" id="nom_club" name="nom_club" value="<?= htmlspecialchars($club->getNomClub()) ?>" required>
                <div class="invalid-feedback">Veuillez entrer un nom de club.</div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description :</label>
                <textarea class="form-control" id="description" name="description" required><?= htmlspecialchars($club->getDescription()) ?></textarea>
                <div class="invalid-feedback">Veuillez entrer une description.</div>
            </div>
            <div class="mb-3">
                <label for="date_creation" class="form-label">Date de création :</label>
                <input type="date" class="form-control" id="date_creation" name="date_creation" value="<?= htmlspecialchars($club->getDateCreation()) ?>" required>
                <div class="invalid-feedback">Veuillez entrer une date de création.</div>
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
            <a href="?controller=backoffice&action=clubList" class="btn btn-secondary">Retour</a>
        </form>
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