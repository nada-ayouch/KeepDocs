<?php
require '../dbconnect.php';
require '../session.php';


$type = $_GET['type'];
$id = $_POST['id'];

if($type == 'user'){
    $query = "DELETE FROM users WHERE id = $id";
    mysqli_query($connection, $query);
    header('Location: user.php');
    exit();
}

if($type == 'service'){
    $query = "DELETE FROM service WHERE id = $id";
    mysqli_query($connection, $query);
    header('Location: service.php');
    exit();
}

mysqli_close($connection);
?>

