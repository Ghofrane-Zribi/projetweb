<?php
require_once '../Config.php';
require_once '../controller/AdhesionC.php';
require_once '../model/Adhesion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_etudiant = isset($_POST['id_etudiant']) ? $_POST['id_etudiant'] : '';
    $id_club = isset($_POST['id_club']) ? $_POST['id_club'] : '';

    if (!empty($id_etudiant) && !empty($id_club)) {
        $adhesion = new Adhesion($id_etudiant, $id_club);
        $adhesionC = new AdhesionC();
        $adhesionC->addAdhesion($adhesion);
        header("Location: listadhesion.php");
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
    <title>Ajouter une Adhésion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h2 class="mt-4">Ajouter une Adhésion</h2>
    <form method="POST">
        <div class="mb-3">
            <label>ID de l'Étudiant</label>
            <input type="number" name="id_etudiant" class="form-control" value="<?= isset($id_etudiant) ? $id_etudiant : '' ?>" required>
        </div>
        <div class="mb-3">
            <label>ID du Club</label>
            <input type="number" name="id_club" class="form-control" value="<?= isset($id_club) ? $id_club : '' ?>" required>
        </div>
        <button type="submit" class="btn btn-success">Ajouter</button>
        <a href="listadhesion.php" class="btn btn-secondary">Retour</a>
    </form>
</body>
</html>