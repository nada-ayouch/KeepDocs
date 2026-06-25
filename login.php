<?php

// Inclure le fichier de connexion à la base de données
require 'dbconnect.php';
// Démarrer la session pour utiliser les variables de session
session_start();
// Vérifier que l'email et le mot de passe ont été envoyés
if (isset($_POST['email']) && isset($_POST['password'])) {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    // Chiffrer le mot de passe avec MD5
    $password = MD5($_POST['password']);
    // Rechercher l'utilisateur dans la base de données
    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";

    //exécuter une requête SQL sur la base de données.
    $result = mysqli_query($connection, $query);

    // Vérifier si un utilisateur correspondant a été trouvé
    if (mysqli_num_rows($result) == 1) {

        // Récupérer les informations de l'utilisateur
        $user = mysqli_fetch_assoc($result);

        // Stocker les informations dans la session
        $_SESSION['userId'] = $user['id'];
        $_SESSION['userEmail'] = $user['email'];
        $_SESSION['userName'] = $user['firstName'];

        // Enregistrer l'heure de connexion de l'utilisateur
        $_SESSION['LAT'] = time();

        // Redirection selon le rôle de l'utilisateur
        if ($user['role'] == 'admin') {

            // Rediriger vers l'espace administrateur
            header('Location: admin/admin.php');
            exit;

        } else {

            // Rediriger vers l'espace employé
            header('Location: employee/employee.php');
            exit;
        }

    } else {

        // Identifiants incorrects
        header('Location: login.php?auth=false');
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KeepDocs</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">

    <!-- HEADER -->
    <header class="home-header">
        <div class="home-logo">
            <h1 class="home-logo-title">KeepDocs</h1>
        </div>

        <nav class="home-navigation">
            <a href="index.php" class="home-login-button">Home</a>
        </nav>
    </header>

    <!-- LOGIN -->
    <main class="login-container">

        <div class="login-card">

            <h1 class="login-title">Welcome Back</h1>
            <p class="login-subtitle">Log in to your account</p>

            <form class="login-form" method="POST">

                <div class="login-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="login-group">
                    <label>Password</label>
                    <input type="password"  id="pass" name="password" placeholder="Enter your password" required>
                </div>
             
                <div class="show-password">
                    <input type="checkbox" id="check" onclick="afficher()">
                    <label id="text" for="check">Show Password</label>
                </div>

                <?php if (isset($_GET['auth'])): ?>
                <p style="color:red;">
                    <?php switch ($_GET['auth']) {
                        case 'false': echo "Please check your login and password";break;
                        case 'inactive': echo "Your subscription is inactive"; break;  
                        case 'nonauth': echo "Please login first"; break;  }?>
                </p>
            <?php endif; ?>

                <button type="submit" class="login-button">
                    Sign in
                </button>

            </form>

            <p class="login-footer">
                © 2026 KeepDocs
            </p>

        </div>

    </main>

</body>

<script>
    function afficher()
{
    if(document.getElementById('check').checked)
        {
        document.getElementById('pass').type="text";
        document.getElementById('text').innerHTML="Hide password";
        }
    else 
    {   document.getElementById('pass').type="password";
        document.getElementById('text').innerHTML="Show password";
    } 
}
</script>
</html>
