<!-- view/admin/admin_ok.php -->
<?php
session_start();
if (!isset($_SESSION['admin_connected'])) {
    header('Location: index.php?action=admin_login');
    exit;
}
?>

<h1>Admin connecté ! 🎉</h1>
<p>La connexion à la base de données fonctionne !</p>