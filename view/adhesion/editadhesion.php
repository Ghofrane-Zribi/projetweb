<?php
require_once '../controller/AdhesionC.php';
require_once '../model/entite/Adhesion.php';

$adhesionController = new AdhesionC();

// Récupération de l'adhésion
try {
    if (!isset($_GET['id'])) {
        throw new Exception("ID d'adhésion manquant");
    }
    
    $adhesion = $adhesionController->showAdhesion($_GET['id']);
    
    // Récupérer la liste des étudiants et clubs
    $etudiants = (new EtudiantManager())->findAll();
    $clubs = (new ClubManager())->findAll();

} catch (Exception $e) {
    header("Location: listadhesion.php?error=" . urlencode($e->getMessage()));
    exit();
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $adhesion->hydrate($_POST);
        $adhesionController->updateAdhesion($adhesion);
        header("Location: listadhesion.php?success=Adhésion mise à jour");
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
    <title>Modifier une Adhésion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h2 class="mt-4">Modifier l'Adhésion #<?= htmlspecialchars($adhesion->getIdAdhesion()) ?></h2>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Étudiant</label>
            <select name="id_etudiant" class="form-control" required>
                <?php foreach ($etudiants as $etudiant): ?>
                    <option value="<?= $etudiant->getIdEtudiant() ?>" 
                        <?= $etudiant->getIdEtudiant() == $adhesion->getIdEtudiant() ? 'selected' : '' ?>>
                        <?= htmlspecialchars($etudiant->getNomComplet()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Club</label>
            <select name="id_club" class="form-control" required>
                <?php foreach ($clubs as $club): ?>
                    <option value="<?= $club->getIdClub() ?>" 
                        <?= $club->getIdClub() == $adhesion->getIdClub() ? 'selected' : '' ?>>
                        <?= htmlspecialchars($club->getNom()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Statut</label>
            <select name="statut" class="form-control" required>
                <option value="en attente" <?= $adhesion->getStatut() == 'en attente' ? 'selected' : '' ?>>En attente</option>
                <option value="accepté" <?= $adhesion->getStatut() == 'accepté' ? 'selected' : '' ?>>Accepté</option>
                <option value="refusé" <?= $adhesion->getStatut() == 'refusé' ? 'selected' : '' ?>>Refusé</option>
            </select>
        </div>

        <button type="submit" class="btn btn-warning">Modifier</button>
        <a href="listadhesion.php" class="btn btn-secondary">Retour</a>
    </form>
</body>
</html>