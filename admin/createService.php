<?php
require '../dbconnect.php';
require '../session.php';


if(isset($_POST['name'],$_POST['description'],$_POST['responsable'])) {
    $ServiceName = mysqli_real_escape_string($connection,$_POST['name']);
    $ServiceDescription = mysqli_real_escape_string($connection,$_POST['description']);
    $ServiceResponsable = mysqli_real_escape_string($connection,$_POST['responsable']);

    $query = "INSERT INTO service (name, description, responsable)
    VALUES ('$ServiceName', '$ServiceDescription', '$ServiceResponsable')";

    $nb = mysqli_query($connection, $query);

    if($nb){
        header("Location: service.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($connection);
    }

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
                <span>Welcome <?php echo $Username." !"; ?> </span>
            </div>
        </header>

        <div class="back-container">
            <a href="service.php" class="back-btn">← Back</a>
        </div>
    
    <form class="service-container" method="POST">

        <h1 class="service-title">Create a Service</h1>

        <div class="service-form">

            <div class="form-group">
                <label>Service Name</label>
                <input type="text" name="name" placeholder="Example: IT Department" required>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea rows="4" name="description" placeholder="Describe the service..." required></textarea>
            </div>

            <div class="form-group">
                <label>Manager</label>
                <input type="text" name="responsable" placeholder="Manager name">
            </div>

            <button type="submit" class="service-btn">Create</button>

        </form>

    </div>

    </main>

</body>
</html>

<?php
mysqli_close($connection);
?>