<?php

require '../dbconnect.php';
require '../session.php';

$maxsizefile = 10000000;

// Vérifier si le formulaire a été soumis
if(isset($_POST['uploadPhoto']))
{
    $_FILES['photo']['error'];
    $_FILES['photo']['type'];
    $_FILES['photo']['size'];
    $_FILES['photo']['name'];
    $_FILES['photo']['tmp_name'];

    if($_FILES['photo']['type'] != 'image/jpeg' 
       && $_FILES['photo']['type'] != 'image/png')
    {
        header('location:profile.php?error=typephoto');
        exit();
    }

    if($_FILES['photo']['size'] > $maxsizefile)
    {
        header('location:profile.php?error=sizefile');
        exit();
    }

    $source = $_FILES['photo']['tmp_name'];
    $photoName = uniqid().".jpg";
    $cible = "uploads/".$photoName;
    move_uploaded_file($source, $cible);
    $query = "update users set photo='$photoName' WHERE id=$UserId";
    mysqli_query($connection, $query);
    header('location:profile.php');
    exit();
}

// SELECT USER
$query = "SELECT
            u.id,
            u.firstName,
            u.lastName,
            u.email,
            u.gender,
            u.photo,
            s.name AS serviceName
          FROM users u
          LEFT JOIN service s ON u.serviceId = s.id where u.id=$UserId";

$result = mysqli_query($connection, $query);
$employee = mysqli_fetch_assoc($result);


// UPDATE PASSWORD
if (isset($_POST['update'])) {
    if (!empty($_POST['password'])) {
        $password = md5($_POST['password']);
        $query = "update users SET password='$password' WHERE id=$UserId";
        mysqli_query($connection, $query);
        header('Location:admin.php?msg=updated');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Profile - KeepDocs</title>
    <link rel="stylesheet" href="../admin.css">
</head>

<body class="employee-body">

   <?php include 'sidebar.php' ?>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- TOP BAR -->
        <header class="topbar">
            <h1>Profile</h1>

            <div class="employee-info">
                <span>Welcome <?php echo $Username." !"; ?> </span>
            </div>
        </header>

    <div class="profile-container">

    <h1 class="profile-title">User Information</h1>

    <div class="profile-card">
            <!-- PHOTO SECTION -->
            <div class="profile-photo-section">
                <div class="photo-circle">
                    <?php if(!empty($employee['photo'])): ?>
                        <img id="preview" src="uploads/<?php echo $employee['photo']; ?>"
                             alt="Profile Photo">
                    <?php else: ?>
                        <img id="preview" src="../images/anonym.png" alt="Default Photo">
                    <?php endif; ?>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <label for="photo-upload" class="upload-btn"> Change Photo </label>
                    <input type="file" id="photo-upload" name="photo"
                           accept="image/*" hidden>

                    <button type="submit" name="uploadPhoto" class="save-photo-btn"> Save Photo </button>

                    <?php
                        if(isset($_GET['error'])) 
                        switch($_GET['error'])
                        {
                            case 'typephoto':echo "<center>Type photo n'est pas autorisée</center>";break;
                            case 'sizefile':echo "<center>Taille maximale : 500Ko</center>";break; 
                        }
                    ?>
                </form>
            </div>


    <div class="profile-form">

        <div class="form-group">
            <label>First Name</label>
            <input type="text" value="<?php echo $employee['firstName'];?>" disabled>
        </div>

        <div class="form-group">
            <label>Last Name</label>
            <input type="text" value="<?php echo $employee['lastName'];?>" disabled>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" value="<?php echo $employee['email'];?>" disabled>
        </div>

        <div class="form-group">
            <label>Gender</label>
            <input type="text" value="<?php echo $employee['gender'];?>" disabled>
        </div>

        <div class="form-group">
            <label>Service</label>
            <input type="text" value="<?php echo $employee['serviceName'];?>" disabled>
        </div>

        <form method="POST">
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="password" placeholder="Enter new password">
            </div>


            <button type="submit" name="update" class="profile-btn"> Update Password </button>
        </form>

    </div>

    </div>

    </main>

  
</body>
</html>
    
    