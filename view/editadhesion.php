<?php
require_once '../config.php';
require_once '../controller/AdhesionC.php';
require_once '../model/Adhesion.php';

$adhesionC = new AdhesionC();

if (!isset($_GET['id'])) {
    header("Location: listadhesion.php");
    exit();
}

$adhesion = $adhesionC->showAdhesion($_GET['id']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $updatedAdhesion = new Adhesion($_POST['id_etudiant'], $_POST['id_club'], $_POST['statut']);
    $adhesionC->updateAdhesion($updatedAdhesion, $_GET['id']);
    header("Location: listadhesion.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une Adhésion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h2 class="mt-4">Modifier l'Adhésion</h2>
    <form method="POST">
        <div class="mb-3">
            <label>ID de l'Étudiant</label>
            <input type="number" name="id_etudiant" class="form-control" value="<?= $adhesion['id_etudiant'] ?>" required>
        </div>
        <div class="mb-3">
            <label>ID du Club</label>
            <input type="number" name="id_club" class="form-control" value="<?= $adhesion['id_club'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Statut</label>
            <select name="statut" class="form-control" required>
                <option value="en attente" <?= $adhesion['statut'] == 'en attente' ? 'selected' : '' ?>>En attente</option>
                <option value="accepté" <?= $adhesion['statut'] == 'accepté' ? 'selected' : '' ?>>Accepté</option>
                <option value="refusé" <?= $adhesion['statut'] == 'refusé' ? 'selected' : '' ?>>Refusé</option>
            </select>
        </div>
        <button type="submit" class="btn btn-warning">Modifier</button>
        <a href="listadhesion.php" class="btn btn-secondary">Retour</a>
    </form>
</body>
</html>