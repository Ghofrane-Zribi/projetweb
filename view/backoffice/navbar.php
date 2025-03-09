<!-- C:\xampp\htdocs\projetweb-test\view\backoffice\navbar.php -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="?controller=backoffice&action=dashboard">Backoffice</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="?controller=backoffice&action=dashboard">Tableau de bord</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?controller=backoffice&action=adminList">Gérer les admins</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?controller=backoffice&action=etudiantList">Gérer les étudiants</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?controller=backoffice&action=clubList">Gérer les clubs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?controller=backoffice&action=adhesionList">Gérer les adhésions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?controller=backoffice&action=membreList">Gérer les membres</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="?controller=backoffice&action=logout">Se déconnecter</a>
                </li>
            </ul>
        </div>
    </div>
</nav>