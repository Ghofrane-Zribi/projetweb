<!-- C:\xampp\htdocs\projetweb-test\view\frontoffice\profile.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h2>Mon Profil</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($etudiant): ?>
            <form method="POST" action="?controller=frontoffice&action=profile">
                <div class="mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($etudiant->getNom()) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($etudiant->getPrenom()) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($etudiant->getEmail()) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="mot_de_passe" class="form-label">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                    <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe">
                </div>
                <div class="mb-3">
                    <label for="date_naissance" class="form-label">Date de naissance</label>
                    <input type="date" class="form-control" id="date_naissance" name="date_naissance" value="<?= htmlspecialchars($etudiant->getDateNaissance()) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="cv" class="form-label">CV (URL ou texte)</label>
                    <input type="text" class="form-control" id="cv" name="cv" value="<?= htmlspecialchars($etudiant->getCv()) ?>">
                </div>
                <button type="submit" class="btn btn-primary">Sauvegarder</button>
            </form>
        <?php else: ?>
            <div class="alert alert-danger">Profil non trouvé.</div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>