<!-- C:\xampp\htdocs\projetweb-test\view\backoffice\etudiant_edit.php -->
<?php if (!isset($_GET['controller']) || !isset($_GET['action'])) {
    header('Location: ../../index.php?controller=backoffice&action=etudiantList');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un étudiant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <h1 class="mb-4">Modifier un étudiant</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="?controller=backoffice&action=etudiantEdit&id=<?= urlencode($etudiant->getIdEtudiant()) ?>" method="POST" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="nom" class="form-label">Nom :</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($etudiant->getNom()) ?>" required>
                <div class="invalid-feedback">Veuillez entrer un nom.</div>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom :</label>
                <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($etudiant->getPrenom()) ?>" required>
                <div class="invalid-feedback">Veuillez entrer un prénom.</div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email :</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($etudiant->getEmail()) ?>" required>
                <div class="invalid-feedback">Veuillez entrer une adresse email valide.</div>
            </div>
            <div class="mb-3">
                <label for="mot_de_passe" class="form-label">Nouveau mot de passe (laisser vide pour ne pas changer) :</label>
                <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe">
            </div>
            <div class="mb-3">
                <label for="date_naissance" class="form-label">Date de naissance :</label>
                <input type="date" class="form-control" id="date_naissance" name="date_naissance" value="<?= htmlspecialchars($etudiant->getDateNaissance()) ?>" required>
                <div class="invalid-feedback">Veuillez entrer une date de naissance.</div>
            </div>
            <div class="mb-3">
                <label for="cv" class="form-label">CV :</label>
                <input type="text" class="form-control" id="cv" name="cv" value="<?= htmlspecialchars($etudiant->getCv()) ?>" required>
                <div class="invalid-feedback">Veuillez entrer un lien ou texte pour le CV.</div>
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
            <a href="?controller=backoffice&action=etudiantList" class="btn btn-secondary">Retour</a>
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