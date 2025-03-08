<?php
// C:\xampp\htdocs\projetweb-test\controller\EtudiantController.php
require_once 'model/manager/EtudiantManager.php';

class EtudiantController {
    private $manager;

    public function __construct() {
        $this->manager = new EtudiantManager();
    }

    public function list() {
        //echo "<pre>DEBUG: Entrée dans list()</pre>";
        try {
            $etudiants = $this->manager->findAll();
            require 'view/etudiant/list.php';
        } catch (Exception $e) {
            $error = "Erreur lors de la récupération des étudiants : " . $e->getMessage();
            //echo "<pre>DEBUG: Exception dans list() : $error</pre>";
            require 'view/etudiant/list.php';
        }
    }

    public function create() {
        echo "<pre>DEBUG: Entrée dans create()</pre>";
        require 'view/etudiant/create.php';
    }

    public function store() {
        echo "<pre>DEBUG: Entrée dans store()</pre>";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //echo "<pre>DEBUG: Données POST reçues : "; var_dump($_POST); echo "</pre>";
            $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
            $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $mot_de_passe = $_POST['mot_de_passe'];
            $date_naissance = filter_input(INPUT_POST, 'date_naissance', FILTER_SANITIZE_STRING);
            $cv = filter_input(INPUT_POST, 'cv', FILTER_SANITIZE_STRING);

            if (!$nom || !$prenom || !$email || !$mot_de_passe) {
                $error = "Tous les champs obligatoires doivent être remplis avec des valeurs valides.";
                //echo "<pre>DEBUG: Validation échouée : $error</pre>";
                require 'view/etudiant/create.php';
                return;
            }

            if ($this->manager->findByEmail($email)) {
                $error = "Cet email est déjà utilisé.";
                //echo "<pre>DEBUG: Email déjà utilisé : $email</pre>";
                require 'view/etudiant/create.php';
                return;
            }

            try {
                $etudiant = new Etudiant(null, $nom, $prenom, $email, $mot_de_passe, $date_naissance, $cv);
                $this->manager->create($etudiant);
                //echo "<pre>DEBUG: Redirection vers la liste après ajout</pre>";
                header('Location: ?controller=etudiant&action=list');
                exit;
            } catch (Exception $e) {
                $error = "Erreur lors de la création de l'étudiant : " . $e->getMessage();
                //echo "<pre>DEBUG: Exception dans store() : $error</pre>";
                require 'view/etudiant/create.php';
            }
        } else {
            //echo "<pre>DEBUG: Redirection vers create() (pas de POST)</pre>";
            header('Location: ?controller=etudiant&action=create');
            exit;
        }
    }

    public function edit($id) {
        //echo "<pre>DEBUG: Entrée dans edit() avec ID : $id</pre>";
        $etudiant = $this->manager->findById($id);
        if (!$etudiant) {
            $error = "Étudiant non trouvé.";
            echo "<pre>DEBUG: Étudiant non trouvé pour ID : $id</pre>";
            require 'view/etudiant/edit.php';
            return;
        }
        require 'view/etudiant/edit.php';
    }

    public function update($id) {
        //echo "<pre>DEBUG: Entrée dans update() avec ID : $id</pre>";
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo "<pre>DEBUG: Données POST reçues : "; var_dump($_POST); echo "</pre>";
            $etudiant = $this->manager->findById($id);
            if (!$etudiant) {
                $error = "Étudiant non trouvé.";
                echo "<pre>DEBUG: Étudiant non trouvé pour ID : $id</pre>";
                require 'view/etudiant/edit.php';
                return;
            }

            $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING);
            $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $mot_de_passe = $_POST['mot_de_passe'];
            $date_naissance = filter_input(INPUT_POST, 'date_naissance', FILTER_SANITIZE_STRING);
            $cv = filter_input(INPUT_POST, 'cv', FILTER_SANITIZE_STRING);

            if (!$nom || !$prenom || !$email) {
                $error = "Les champs nom, prénom et email sont obligatoires.";
                echo "<pre>DEBUG: Validation échouée : $error</pre>";
                require 'view/etudiant/edit.php';
                return;
            }

            $existing = $this->manager->findByEmail($email);
            if ($existing && $existing->getIdEtudiant() != $id) {
                $error = "Cet email est déjà utilisé par un autre étudiant.";
                echo "<pre>DEBUG: Email déjà utilisé : $email</pre>";
                require 'view/etudiant/edit.php';
                return;
            }

            try {
                $etudiant->setNom($nom);
                $etudiant->setPrenom($prenom);
                $etudiant->setEmail($email);
                if (!empty($mot_de_passe)) {
                    $etudiant->setMotDePasse($mot_de_passe);
                }
                $etudiant->setDateNaissance($date_naissance);
                $etudiant->setCv($cv);
                $this->manager->update($etudiant);
                echo "<pre>DEBUG: Redirection vers la liste après mise à jour</pre>";
                header('Location: ?controller=etudiant&action=list');
                exit;
            } catch (Exception $e) {
                $error = "Erreur lors de la mise à jour : " . $e->getMessage();
                echo "<pre>DEBUG: Exception dans update() : $error</pre>";
                require 'view/etudiant/edit.php';
            }
        } else {
            echo "<pre>DEBUG: Redirection vers edit() (pas de POST)</pre>";
            header('Location: ?controller=etudiant&action=edit&id=' . urlencode($id));
            exit;
        }
    }

    public function delete($id) {
        echo "<pre>DEBUG: Entrée dans delete() avec ID : $id</pre>";
        try {
            $etudiant = $this->manager->findById($id);
            if ($etudiant) {
                $this->manager->delete($id);
            }
            echo "<pre>DEBUG: Redirection vers la liste après suppression</pre>";
            header('Location: ?controller=etudiant&action=list');
            exit;
        } catch (Exception $e) {
            $error = "Erreur lors de la suppression : " . $e->getMessage();
            echo "<pre>DEBUG: Exception dans delete() : $error</pre>";
            require 'view/etudiant/list.php';
        }
    }
}
?>