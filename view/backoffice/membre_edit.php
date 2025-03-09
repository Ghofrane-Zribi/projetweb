<!-- C:\xampp\htdocs\projetweb-test\view\backoffice\membre_edit.php -->
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
    <title>Modifier un membre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="mb-4">Modifier un membre</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="?controller=backoffice&action=membreEdit&id=<?= urlencode($membre->getIdMembre()) ?>" method="POST" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="id_etudiant" class="form-label">Étudiant :</label>
                <select class="form-control" id="id_etudiant" name="id_etudiant" required>
                    <option value="">Sélectionner un étudiant</option>
                    <?php foreach ($etudiants as $etudiant): ?>
                        <option value="<?= htmlspecialchars($etudiant->getIdEtudiant()) ?>" 
                                <?= $membre->getIdEtudiant() == $etudiant->getIdEtudiant() ? 'selected' : '' ?>>
                            <?= htmlspecialchars($etudiant->getNom() . ' ' . $etudiant->getPrenom()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Veuillez sélectionner un étudiant.</div>
            </div>
            <div class="mb-3">
                <label for="id_club" class="form-label">Club :</label>
                <select class="form-control" id="id_club" name="id_club" required>
                    <option value="">Sélectionner un club</option>
                    <?php foreach ($clubs as $club): ?>
                        <option value="<?= htmlspecialchars($club->getIdClub()) ?>" 
                                <?= $membre->getIdClub() == $club->getIdClub() ? 'selected' : '' ?>>
                            <?= htmlspecialchars($club->getNomClub()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Veuillez sélectionner un club.</div>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Rôle :</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="président" <?= $membre->getRole() === 'président' ? 'selected' : '' ?>>Président</option>
                    <option value="trésorier" <?= $membre->getRole() === 'trésorier' ? 'selected' : '' ?>>Trésorier</option>
                    <option value="secrétaire" <?= $membre->getRole() === 'secrétaire' ? 'selected' : '' ?>>Secrétaire</option>
                    <option value="membre" <?= $membre->getRole() === 'membre' ? 'selected' : '' ?>>Membre</option>
                </select>
                <div class="invalid-feedback">Veuillez sélectionner un rôle.</div>
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
            <a href="?controller=backoffice&action=membreList" class="btn btn-secondary">Retour</a>
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