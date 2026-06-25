<?php

require '../dbconnect.php';
require '../session.php';

$query = "SELECT
            u.id,
            u.firstName,
            u.lastName,
            u.email,
            u.gender,
            u.role,
            u.createdAt,
            s.name AS serviceName
          FROM users u 
          LEFT JOIN service s ON u.serviceId = s.id
          ORDER BY u.createdAt DESC LIMIT 5";

$result = mysqli_query($connection, $query);
$recentUsers=mysqli_num_rows($result);

$subquery = "SELECT COUNT(*) AS total FROM users WHERE role='admin'";
$subresult = mysqli_query($connection, $subquery);
$row = mysqli_fetch_assoc($subresult);
$numberUsersA = $row['total'];

$subquery2 = "SELECT COUNT(*) AS total FROM users WHERE role='employee'";
$subresult2 = mysqli_query($connection, $subquery2);
$row2 = mysqli_fetch_assoc($subresult2);
$numberUsersE = $row2['total'];

$subquery3 = "SELECT COUNT(*) AS total FROM service";
$subresult3 = mysqli_query($connection, $subquery3);
$row3 = mysqli_fetch_assoc($subresult3);
$numberServices = $row3['total'];

$subquery4 = "SELECT COUNT(*) AS total FROM documents";
$subresult4 = mysqli_query($connection, $subquery4);
$row4 = mysqli_fetch_assoc($subresult4);
$numberDocs = $row4['total'];

$counter = 0;
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - KeepDocs</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body class="admin-body">

   <?php include 'sidebar.php' ?>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- TOP BAR -->
        <header class="topbar">
            <h1>Admin Dashboard</h1>

            <div class="admin-info">
                <span>Welcome <?php echo $Username." !"; ?> </span>
            </div>
        </header>

        <!-- CONTENT -->
        <section class="dashboard-cards">

             <div class="card">
                <h3>Documents</h3>
                <p><?php echo $numberDocs; ?></p>
            </div>

            <div class="card">
                <h3>Admins</h3>
                <p><?php echo $numberUsersA; ?></p>
            </div>

            <div class="card">
                <h3>Employees</h3>
                <p><?php echo $numberUsersE; ?></p>
            </div>

            <div class="card">
                <h3>Services</h3>
                <p><?php echo $numberServices; ?></p>
            </div>


        </section>


        <section class="bloc">

            <h3>Latest Registered Members</h3>
            
            <table class="tableau">
                <?php if($recentUsers): ?>
                <tr>
                    <th>N°</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Service</th>
                    <th>Role</th>
                    <th>Created at</th>
                </tr>
                <?php while($users=mysqli_fetch_assoc($result)): ?>
                    <?php $counter++ ?>
                <tr>
                        <td><?php echo $counter;?></td>  
                        <td><?php echo $users['firstName'];?> </td> 
                        <td><?php echo $users['lastName'];?></td> 
                        <td><?php echo $users['email'];?></td>
                        <td><?php echo $users['gender'];?></td>
                        <td><?php echo $users['serviceName'];?></td>
                        <td><?php echo $users['role']?></td> 
                        <td><span class="badge valide"><?php echo date("d M Y H:i", strtotime($users['createdAt'])); ?></span></td>
                    
                </tr>
            <?php endwhile ?>

            </table>

        </section>
        <?php endif ?>

    </main>

</body>
</html>