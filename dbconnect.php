<?php

// Adresse du serveur de base de données
define('HOST', 'localhost');
// Nom d'utilisateur MySQL
define('USER', 'root');
// Mot de passe MySQL
define('PASS', '');
// Numéro du port MySQL (par défaut : 3306)
define('PORT', 3306);
// Nom de la base de données
define('DB', 'keepdocs');
// Connexion à la base de données MySQL
$connection = mysqli_connect(HOST, USER, PASS, DB);
// Vérification de la connexion
if($connection == false)
{
    // Afficher un message d'erreur
    echo "Connection error";
    // Arrêter l'exécution du script
    exit(1);//on met 1 car le programme s'est arrêté à cause d'une erreur
}

?>