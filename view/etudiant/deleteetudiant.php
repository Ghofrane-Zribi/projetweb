<?php
require_once '../Config.php';
require_once '../controller/EtudiantC.php';

if (isset($_GET['id'])) {
    $etudiantC = new EtudiantC();
    $etudiantC->deleteEtudiant($_GET['id']);
    header("Location: listetudiant.php");
    exit();
}
?>