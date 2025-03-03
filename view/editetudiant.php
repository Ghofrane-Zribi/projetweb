<?php
// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config.php';
require_once '../controller/EtudiantC.php';
require_once '../model/Etudiant.php';

$etudiantC = new EtudiantC();

// Vérifier si l'ID de l'étudiant est passé dans l'URL
if (!isset($_GET['id'])) {
    header("Location: listetudiant.php");
    exit();
}

// Récupérer les informations de l'étudiant à modifier
$etudiant = $etudiantC->showEtudiant($_GET['id']);

// Si l'étudiant n'existe pas, rediriger vers la liste
if (!$etudiant) {
    header("Location: listetudiant.php");
    exit();
}

// Traitement du formulaire de modification
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier que tous les champs obligatoires sont remplis
    if (!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['date_naissance']) && !empty($_POST['cv'])) {
        // Si un nouveau mot de passe est saisi, le hacher
        $mot_de_passe = !empty($_POST['mot_de_passe']) ? password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT) : $etudiant['mot_de_passe'];

        // Récupérer id_club (peut être null)
        $id_club = !empty($_POST['id_club']) ? $_POST['id_club'] : null;

        // Créer un nouvel objet Etudiant avec les données du formulaire
        $updatedEtudiant = new Etudiant(
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['email'],
            $mot_de_passe,
            $_POST['date_naissance'],
            $_POST['cv'],
            $id_club
        );

        // Mettre à jour l'étudiant dans la base de données
        try {
            if ($etudiantC->updateEtudiant($updatedEtudiant, $_GET['id'])) {
                // Rediriger vers la liste des étudiants après la modification
                header("Location: listetudiant.php");
                exit();
            } else {
                echo "Erreur lors de la mise à jour de l'étudiant.";
            }
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        echo "Tous les champs obligatoires doivent être remplis.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Étudiant</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container">
    <h2 class="mt-4">Modifier l'Étudiant</h2>
    <form method="POST">
        <div class="mb-3">
            <label>Nom</label>
            <input type="text" name="nom" class="form-control" value="<?= $etudiant['nom'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Prénom</label>
            <input type="text" name="prenom" class="form-control" value="<?= $etudiant['prenom'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= $etudiant['email'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Mot de passe (laisser vide pour ne pas modifier)</label>
            <input type="password" name="mot_de_passe" class="form-control">
        </div>
        <div class="mb-3">
            <label>Date de Naissance</label>
            <input type="date" name="date_naissance" class="form-control" value="<?= $etudiant['date_naissance'] ?>" required>
        </div>
        <div class="mb-3">
            <label>CV (URL)</label>
            <input type="text" name="cv" class="form-control" value="<?= $etudiant['cv'] ?>" required>
        </div>
        <div class="mb-3">
            <label>ID du Club (optionnel)</label>
            <input type="number" name="id_club" class="form-control" value="<?= $etudiant['id_club'] ?>">
        </div>
        <button type="submit" class="btn btn-warning">Modifier</button>
        <a href="listetudiant.php" class="btn btn-secondary">Retour</a>
    </form>
</body>
</html>