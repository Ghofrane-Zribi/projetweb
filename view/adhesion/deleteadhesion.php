<?php
require_once '../controller/AdhesionC.php';

try {
    if (!isset($_GET['id'])) {
        throw new Exception("ID d'adhésion manquant");
    }

    $adhesionController = new AdhesionC();
    $adhesionController->deleteAdhesion($_GET['id']);
    
    header("Location: listadhesion.php?success=Adhésion supprimée avec succès");
    exit();

} catch (Exception $e) {
    header("Location: listadhesion.php?error=" . urlencode($e->getMessage()));
    exit();
}
?>