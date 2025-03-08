<!-- C:\xampp\htdocs\projetweb-test\view\etudiant\login.php -->
<?php if (!isset($_GET['controller']) || !isset($_GET['action'])) {
    header('Location: ../../index.php?controller=etudiant&action=login');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Étudiant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Connexion Étudiant</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="?controller=etudiant&action=login" method="POST" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="email" class="form-label">Email :</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <div class="invalid-feedback">Veuillez entrer une adresse email valide.</div>
            </div>
            <div class="mb-3">
                <label for="mot_de_passe" class="form-label">Mot de passe :</label>
                <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
                <div class="invalid-feedback">Veuillez entrer un mot de passe.</div>
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
            <a href="?controller=etudiant&action=create" class="btn btn-success ms-2">S'inscrire</a>
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