<?php
require '../dbconnect.php';
require '../session.php';


$id = $_POST['id'];

    $query = "DELETE FROM documents WHERE id = $id";
    mysqli_query($connection, $query);
    header('Location: document.php');
    exit();

mysqli_close($connection);
?>

