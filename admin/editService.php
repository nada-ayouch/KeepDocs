<?php
require '../dbconnect.php';
require '../session.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    die("Missing ID");
}

$query = "SELECT * FROM service WHERE id=$id";
$result = mysqli_query($connection, $query);
$service = mysqli_fetch_array($result);


?>

<?php

if(isset($_POST['name'],$_POST['description'],$_POST['responsable'])) {
    $ServiceName = mysqli_real_escape_string($connection,$_POST['name']);
    $ServiceDescription = mysqli_real_escape_string($connection,$_POST['description']);
    $ServiceResponsable = mysqli_real_escape_string($connection,$_POST['responsable']);


$query = "UPDATE service SET name='$ServiceName', description ='$ServiceDescription', responsable='$ServiceResponsable' WHERE id=$id";
$nb = mysqli_query($connection, $query);

if($nb){
    header("Location: service.php");
    exit;
}else{
    echo "Erreur : " . mysqli_error($connection);
}

mysqli_close($connection);
}
?>
 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - KeepDocs</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body class="admin-body">

<?php include 'sidebar.php' ?>

<!-- MAIN CONTENT -->
<main class="main-content">

    <!-- TOP BAR -->
    <header class="topbar">
        <h1>Services</h1>

        <div class="admin-info">
            <span>Welcome <?php echo $Username . " !"; ?> </span>
        </div>
    </header>

    <div class="back-container">
        <a href="service.php" class="back-btn">← Back</a>
    </div>

    <form class="service-container" method="POST">

        <h1 class="service-title">Update a Service</h1>

        <div class="service-form">

            <div class="form-group">
            <input type="hidden" name="id" value="<?php echo $service['id'];?>">
            </div>
            <div class="form-group">
                <label>Service Name</label>
                <input type="text" name="name" value="<?php echo $service['name']; ?>" required>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea rows="4" name="description" required><?php echo $service['description']; ?></textarea>
            </div>

            <div class="form-group">
                <label>Manager</label>
                <input type="text" name="responsable" value="<?php echo $service['responsable']; ?>">
            </div>

            <button type="submit" class="service-btn">Update</button>

        </div>

    </form>

</main>

</body>
</html>