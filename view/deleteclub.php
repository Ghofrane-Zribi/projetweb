<?php
require_once '../Config.php';
require_once '../controller/ClubC.php';

if (isset($_GET['id'])) {
    $clubC = new ClubC();
    $clubC->deleteClub($_GET['id']);
    header("Location: listclub.php");
    exit();
}
?>
