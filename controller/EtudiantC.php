<?php
require_once '../core/Database.php';
require_once '../model/entite/Etudiant.php';
require_once '../model/manager/EtudiantManager.php';

class EtudiantC {
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $etudiant = new Etudiant();
                $etudiant->hydrate($_POST);
                
                $manager = new EtudiantManager();
                $id = $manager->create($etudiant);
                
                $_SESSION['user'] = $manager->find($id);
                header('Location: /dashboard');
                exit;
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header('Location: /register');
                exit;
            }
        }require __DIR__ . '/../view/etudiant/register_view.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $manager = new EtudiantManager();
                $etudiant = $manager->findByEmail($_POST['email']);
                
                if ($etudiant && password_verify($_POST['mdp'], $etudiant->getMotDePasse())) {
                    $_SESSION['user'] = $etudiant;
                    header('Location: /dashboard');
                    exit;
                }
                
                throw new Exception("Identifiants invalides");
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header('Location: /login');
                exit;
            }
        }require __DIR__ . '/../view/etudiant/login.php';
    }

    public function updateEtudiant($id) {
        try {
            $manager = new EtudiantManager();
            $etudiant = $manager->find($id);
            $etudiant->hydrate($_POST);
            
            if ($manager->update($etudiant)) {
                $_SESSION['success'] = "Profil mis à jour";
            }
            
            header('Location: /profile');
            exit;
            
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: /profile/edit');
            exit;
        }
    }
}
?>