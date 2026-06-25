<?php

require '../dbconnect.php';
require '../session.php';

if(isset($_POST['firstName'],$_POST['lastName'],$_POST['email'],
       $_POST['gender'],$_POST['serviceId'],$_POST['role'],$_POST['password'])) {
   
    $userFirstName =mysqli_real_escape_string($connection,$_POST['firstName']);
    $userLastName = mysqli_real_escape_string($connection,$_POST['lastName']);
    $userEmail = mysqli_real_escape_string($connection,$_POST['email']);
    $userGender = mysqli_real_escape_string($connection,$_POST['gender']);
    $userServiceId = mysqli_real_escape_string($connection,$_POST['serviceId']);
    $userRole = mysqli_real_escape_string($connection,$_POST['role']);
    $userPassword = MD5($_POST['password']);
    
    $query = "INSERT INTO users (firstName,lastName,email,gender,serviceId,role,password)
    VALUES ('$userFirstName','$userLastName','$userEmail','$userGender','$userServiceId','$userRole','$userPassword')";

    $nb = mysqli_query($connection, $query);

    if($nb){
        header("Location: user.php");
        exit();
    } else {
        echo "Erreur: " . mysqli_error($connection);
    }

}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users - KeepDocs</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body class="admin-body">

   <?php include 'sidebar.php' ?>

     <!-- MAIN CONTENT -->
    <main class="main-content">
        <!-- TOP BAR -->
        <header class="topbar">
            <h1>Users</h1>

            <div class="admin-info">
                <span>Welcome <?php echo $Username." !"; ?> </span>
            </div>
        </header>

        <div class="back-container">
            <a href="user.php" class="back-btn">← Back</a>
        </div>
    
    <form class="user-container" method="POST">

    <h1 class="user-title">Create a user</h1>

    <div class="user-form">

        <div class="form-group">
            <label>First Name</label>
            <input type="text" name="firstName" placeholder="enter first name">
        </div>

        <div class="form-group">
            <label>Last Name</label>
            <input type="text" name="lastName" placeholder="enter last name">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="enter email">
        </div>

        <div class="form-group">
            <label>Gender</label>
            <select name="gender">
                <option value='male'>Male</option>
                <option value='female'>Female</option>
            </select>
        </div>

        <div class="form-group">
            <label>Service</label>
            <?php $subquery = "SELECT * FROM service";
                $subresult = mysqli_query($connection, $subquery);?>
                <select name="serviceId">
                <?php while($service = mysqli_fetch_assoc($subresult)): ?>
                    <option value="<?php echo $service['id']?>"><?php echo $service['name']?></option>
                <?php endwhile; ?>
                </select>
        </div>

        <div class="form-group">
            <label>Role</label>
            <select name="role">
                <option value='admin'>Admin</option>
                <option value='employee'>Employee</option>
            </select>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="enter password">
        </div>

    </div>

    <button type="submit" class="user-btn">Create</button>

</form>
    </div>

    </main>

    

</body>
</html>

<?php
mysqli_close($connection);
?>