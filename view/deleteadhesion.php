<?php
require_once '../config.php';
require_once '../controller/AdhesionC.php';

if (isset($_GET['id'])) {
    $adhesionC = new AdhesionC();
    $adhesionC->deleteAdhesion($_GET['id']);
    header("Location: listadhesion.php");
    exit();
}
?>