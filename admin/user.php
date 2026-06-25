<?php

require '../dbconnect.php';
require '../session.php';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if($page < 1)
{
    $page = 1;
}

$limit = 5;
$start = ($page - 1) * $limit;

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
          LIMIT $start, $limit";

$result = mysqli_query($connection, $query);
$numUsers = mysqli_num_rows($result);

$countQuery = "SELECT COUNT(*) AS total FROM users";
$countResult = mysqli_query($connection, $countQuery);

$row = mysqli_fetch_assoc($countResult);

$totalUsers = $row['total'];
$totalPages = ceil($totalUsers / $limit);

$counter = $start;;
?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees - KeepDocs</title>
    <link rel="stylesheet" href="admin.css">
</head>

<body class="admin-body">

   <?php include 'sidebar.php' ?>

     <!-- MAIN CONTENT -->
    <main class="main-content">
        <!-- TOP BAR -->
        <header class="topbar">
            <h1>Employees</h1>

            <div class="admin-info">
                <span>Welcome <?php echo $Username." !"; ?> </span>
            </div>

        </header>


         <div class="actions-bar">
        <a href="createUser.php" class="add-service-btn">+ Add Employee</a>
    </div>

    <!-- TABLE SERVICES -->
    <div class="table-container">

        <table class="services-table">

            <thead>
                <tr>
                    <th>N°</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Service</th>
                    <th>Role</th>
                    <th>Created at</th>
                    <th>Actions</th>
                </tr>
            </thead>
                
            <tbody>
                <?php if ($result && $numUsers > 0): ?>
                    <?php  while ($user = mysqli_fetch_array($result)):?>
                    <?php $counter++ ?> 
                    <tr>
                        <td><?php echo $counter;?></td>  
                        <td><?php echo $user['firstName'];?> </td> 
                        <td><?php echo $user['lastName'];?></td> 
                        <td><?php echo $user['email'];?></td>
                        <td><?php echo $user['gender'];?></td>
                        <td><?php echo $user['serviceName']?></td> 
                        <td><?php echo $user['role']?></td>  
                        <td><span class="badge valide"><?php echo date("d M Y", strtotime($user['createdAt'])); ?></span></td>
                        <td>
                            <form action="editUser.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <input type="hidden" name="page" value="<?php echo $page; ?>">
                                <button type="submit" class="btn btn-edit">✏️</button>
                            </form>

                                <form action="delete.php?type=user" method="post">
                                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                <button type="submit" class="btn btn-danger" onclick =" return confirm('do you want to delete ?')">🗑️</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
                <?php endif; ?>
            </tbody>

        </table>

    </div>
        
            <div class="pagination">
            <?php
            for($i = 1; $i <= $totalPages; $i++)
            {
                $active = ($i == $page) ? "active" : "";
                echo "<a class='$active' href='?page=$i'>$i</a>";
            }
            ?>
        </div>

    </main>



</body>
</html>