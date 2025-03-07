<?php
require_once '../Config.php';
require_once '../controller/AdminC.php';
require_once '../model/Administrateur.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $mdp = isset($_POST['mdp']) ? $_POST['mdp'] : '';
    $role = isset($_POST['role']) ? $_POST['role'] : 'moderateur';

    if (!empty($nom) && !empty($email) && !empty($mdp)) {
        $admin = new Administrateur($nom, $email, $mdp, $role);
        $adminC = new AdminC();
        $adminC->addAdmin($admin);
        header("Location: listadherent.php");
        exit();
    } else {
        echo "<p>Veuillez remplir tous les champs obligatoires !</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Administrateur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h2 class="mt-4">Ajouter un Administrateur</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" value="<?= isset($nom) ? $nom : '' ?>" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= isset($email) ? $email : '' ?>" required>
        </div>
        <div class="mb-3">
            <label>Mot de passe</label>
            <input type="password" name="mdp" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Rôle</label>
            <select name="role" class="form-control">
                <option value="moderateur">Modérateur</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Ajouter</button>
        <a href="listadherent.php" class="btn btn-secondary">Retour</a>
    </form>
</body>
</html>