<?php
require_once '../Config.php';
require_once '../controller/AdhesionC.php';

if (isset($_GET['id_etudiant']) && isset($_GET['id_club'])) {
    $adhesionC = new AdhesionC();
    $adhesionC->deleteAdhesion($_GET['id_etudiant'], $_GET['id_club']);
    header("Location: listadhesion.php");
    exit();
}
?>