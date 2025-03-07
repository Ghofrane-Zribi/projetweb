<?php
require_once '../controller/AdhesionC.php';
require_once '../model/manager/EtudiantManager.php';
require_once '../model/manager/ClubManager.php';

$error = null;
$success = null;

// Récupération des étudiants et clubs
try {
    $etudiants = (new EtudiantManager())->findAll();
    $clubs = (new ClubManager())->findAll();
} catch(Exception $e) {
    $error = "Erreur de chargement des données : " . $e->getMessage();
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $adhesion = new Adhesion();
        $adhesion->hydrate($_POST);
        
        $controller = new AdhesionC();
        $controller->addAdhesion($adhesion);
        
        header("Location: listadhesion.php?success=Adhésion créée avec succès");
        exit();
        
    } catch (Exception $e) {
        $error = $e->getMessage();
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
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Étudiant</label>
            <select name="id_etudiant" class="form-control" required>
                <option value="">Choisir un étudiant...</option>
                <?php foreach ($etudiants as $etudiant): ?>
                    <option value="<?= htmlspecialchars($etudiant->getIdEtudiant()) ?>" 
                        <?= isset($_POST['id_etudiant']) && $_POST['id_etudiant'] == $etudiant->getIdEtudiant() ? 'selected' : '' ?>>
                        <?= htmlspecialchars($etudiant->getNomComplet()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Club</label>
            <select name="id_club" class="form-control" required>
                <option value="">Choisir un club...</option>
                <?php foreach ($clubs as $club): ?>
                    <option value="<?= htmlspecialchars($club->getIdClub()) ?>" 
                        <?= isset($_POST['id_club']) && $_POST['id_club'] == $club->getIdClub() ? 'selected' : '' ?>>
                        <?= htmlspecialchars($club->getNom()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Statut initial</label>
            <select name="statut" class="form-control" required>
                <option value="en attente" selected>En attente</option>
                <option value="accepté">Accepté</option>
                <option value="refusé">Refusé</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Ajouter</button>
        <a href="listadhesion.php" class="btn btn-secondary">Retour</a>
    </form>
</body>
</html>