<?php
require_once '../Config.php';
require_once '../controller/AdminC.php';

if (isset($_GET['id'])) {
    $adminC = new AdminC();
    $adminC->deleteAdmin($_GET['id']);
    header("Location: listadherent.php");
    exit();
}
?>