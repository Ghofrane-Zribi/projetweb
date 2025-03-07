
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion Admin</title>
</head>
<body>
    <form action="admin_auth.php" method="post">
        <h2>Connexion Admin</h2>
        
        <label>Email:</label>
        <input type="email" name="email" required><br>
        
        <label>Mot de passe:</label>
        <input type="password" name="password" required><br>
        
        <button type="submit" name="login">Se connecter</button>
        <button type="submit" name="register">S'inscrire</button>
    </form>
</body>
</html>
<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'db_projet';

// Connexion MySQLi procédural
$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Erreur de connexion : " . mysqli_connect_error());
}


// Fonction d'inscription
function register_admin($conn, $email, $password) {
    // Vérification email unique
    $check = mysqli_query($conn, "SELECT * FROM admins WHERE email = '$email'");
    if (mysqli_num_rows($check) > 0) {
        die("Cet email est déjà utilisé");
    }
    
    // Hachage mot de passe
    $hash = password_hash($password, PASSWORD_BCRYPT);
    
    // Insertion sécurisée avec requête préparée
    $stmt = mysqli_prepare($conn, "INSERT INTO admins (email, password_hash) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $email, $hash);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "Compte admin créé avec succès !";
    } else {
        echo "Erreur : " . mysqli_error($conn);
    }
}

// Fonction de connexion
function login_admin($conn, $email, $password) {
    $result = mysqli_query($conn, "SELECT * FROM admins WHERE email = '$email'");
    
    if (mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);
        
        if (password_verify($password, $admin['password_hash'])) {
            session_start();
            $_SESSION['admin_id'] = $admin['id'];
            echo "Connexion réussie ! Bienvenue " . $admin['email'];
        } else {
            echo "Mot de passe incorrect";
        }
    } else {
        echo "Aucun compte trouvé avec cet email";
    }
}

// Traitement des actions
if (isset($_POST['register'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    register_admin($conn, $email, $password);
}

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    login_admin($conn, $email, $password);
}

mysqli_close($conn);
?>