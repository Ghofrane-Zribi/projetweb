<?php
require_once '../config.php';
require_once '../controller/AdminC.php';
require_once '../model/Administrateur.php';

$adminC = new AdminC();

if (!isset($_GET['id'])) {
    header("Location: listadherent.php");
    exit();
}

$admin = $adminC->showAdmin($_GET['id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $updatedAdmin = new Administrateur($_POST['nom'], $_POST['email'], $_POST['mdp'], $_POST['role']);
    $adminC->updateAdmin($updatedAdmin, $_GET['id']);
    header("Location: listadherent.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h2 class="mt-4">Modifier l'Administrateur</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" value="<?= $admin['nom'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= $admin['email'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Mot de passe</label>
            <input type="password" name="mdp" class="form-control" placeholder="Laisser vide pour ne pas changer">
        </div>
        <div class="mb-3">
            <label>Rôle</label>
            <select name="role" class="form-control" required>
                <option value="moderateur" <?= $admin['role'] == 'moderateur' ? 'selected' : '' ?>>Modérateur</option>
                <option value="admin" <?= $admin['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-warning">Modifier</button>
        <a href="listadherent.php" class="btn btn-secondary">Retour</a>
    </form>
</body>
</html>