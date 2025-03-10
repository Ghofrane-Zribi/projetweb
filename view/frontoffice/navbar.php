<!-- C:\xampp\htdocs\projetweb-test\view\frontoffice\navbar.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="?controller=frontoffice&action=clubs_list">Étudiant</a>
        <div class="navbar-nav">
            <?php if (isset($_SESSION['etudiant_id'])): ?>
                <a class="nav-link" href="?controller=frontoffice&action=clubs_list">Clubs</a>
                <a class="nav-link" href="?controller=frontoffice&action=profile">Profil</a>
                <a class="nav-link" href="?controller=frontoffice&action=my_clubs">Mes Clubs</a>
                <a class="nav-link" href="?controller=frontoffice&action=logout">Déconnexion</a>
            <?php else: ?>
                <a class="nav-link" href="?controller=frontoffice&action=login">Connexion</a>
                <a class="nav-link" href="?controller=frontoffice&action=register">S'inscrire</a>
            <?php endif; ?>
        </div>
    </div>
</nav>