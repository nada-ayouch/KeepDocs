<?php

// Démarrer la session si elle n'est pas déjà active
if (session_status() === PHP_SESSION_NONE) { //constante qui indique qu'aucune session n'a été démarrée.
    session_start();
}

// Durée maximale d'inactivité (300 secondes = 5 minutes)
$ttl = 300;

// Vérifier si l'utilisateur est connecté
if(!isset($_SESSION['userId'])) {
    // Rediriger vers la page de connexion
    header('Location:/KeepDocs/login.php?auth=nonauth');
    exit;
}

// Vérifier si la session a expiré
if(time() - $_SESSION['LAT'] > $ttl ){

    // Déconnecter l'utilisateur
    header('location:/KeepDocs/disconnect.php');
    exit;

} else {

    // Mettre à jour l'heure de la dernière activité
    $_SESSION['LAT'] = time();
}

// Récupérer les informations de l'utilisateur connecté
$UserId = $_SESSION['userId'];
$Useremail = $_SESSION['userEmail'];
$Username = $_SESSION['userName'];

?>