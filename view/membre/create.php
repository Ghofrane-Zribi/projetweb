<!-- C:\xampp\htdocs\projetweb-test\view\membre\create.php -->
<?php if (!isset($_GET['controller']) || !isset($_GET['action'])) {
    header('Location: ../../index.php?controller=membre&action=create');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un membre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Ajouter un membre</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="?controller=membre&action=store" method="POST" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="id_etudiant" class="form-label">Étudiant :</label>
                <select class="form-select" id="id_etudiant" name="id_etudiant" required>
                    <option value="">Sélectionnez un étudiant</option>
                    <?php foreach ($etudiants as $etudiant): ?>
                        <option value="<?= htmlspecialchars($etudiant->getIdEtudiant()) ?>">
                            <?= htmlspecialchars($etudiant->getNom() . ' ' . $etudiant->getPrenom()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Veuillez sélectionner un étudiant.</div>
            </div>
            <div class="mb-3">
                <label for="id_club" class="form-label">Club :</label>
                <select class="form-select" id="id_club" name="id_club" required>
                    <option value="">Sélectionnez un club</option>
                    <?php foreach ($clubs as $club): ?>
                        <option value="<?= htmlspecialchars($club->getIdClub()) ?>">
                            <?= htmlspecialchars($club->getNomClub()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Veuillez sélectionner un club.</div>
            </div>
            <div class="mb-3">
                <label for="date_inscription" class="form-label">Date d'inscription :</label>
                <input type="date" class="form-control" id="date_inscription" name="date_inscription" required>
                <div class="invalid-feedback">Veuillez entrer une date d'inscription.</div>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Rôle :</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="membre">Membre</option>
                    <option value="président">Président</option>
                    <option value="trésorier">Trésorier</option>
                    <option value="secrétaire">Secrétaire</option>
                </select>
                <div class="invalid-feedback">Veuillez sélectionner un rôle.</div>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="?controller=membre&action=list" class="btn btn-secondary">Retour</a>
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