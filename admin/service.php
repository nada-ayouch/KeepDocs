<?php

require '../dbconnect.php';
require '../session.php';

$query = "SELECT * FROM service";
$result = mysqli_query($connection, $query);
$numServices = mysqli_num_rows($result);
$counter = 0;
?>



<!DOCTYPE html>
<html lang="fr">
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

        <!-- ACTION BUTTON -->
    <div class="actions-bar">
        <a href="createService.php" class="add-service-btn">+ Add Service</a>
    </div>

<!-- TABLE SERVICES -->
<div class="table-container">

    <table class="services-table">

        <thead>
            <tr>
                <th>N°</th>
                <th>Name</th>
                <th>Description</th>
                <th>Responsable</th>
                <th>Actions</th>
            </tr>
        </thead>
            
        <tbody>
            <?php if ($result && $numServices > 0): ?>
                <?php  while ($service = mysqli_fetch_assoc($result)):?>
                <?php $counter++ ?> 
                <tr>
                    <td><?php echo $counter;?></td>  
                    <td><?php echo $service['name'];?> </td> 
                    <td><?php echo $service['description'];?></td> 
                    <td><?php echo $service['responsable'];?></td> 
                    <td>
                        <form action="editService.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $service['id'];?>">
                            <button type="submit" class="btn btn-edit">✏️</button>
                        </form>
        
                    
                            <form action="delete.php?type=service" method="post">
                            <input type="hidden" name="id" value="<?php echo $service['id']; ?>">
                            <button type="submit" class="btn btn-danger" onclick =" return confirm('do you want to delete ?')"> 🗑️</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            <?php endif; ?>
        </tbody>

    </table>

</div>
    
</main>
   

</body>
</html>