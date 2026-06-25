<?php

require '../dbconnect.php';
require '../session.php';

$subquery = "SELECT COUNT(*) AS total FROM documents WHERE userId= $UserId";
$subresult = mysqli_query($connection, $subquery);
$row = mysqli_fetch_assoc($subresult);
$numberDocs = $row['total'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard - KeepDocs</title>
    <link rel="stylesheet" href="employee.css">
</head>

<body class="employee-body">

   <?php include 'sidebar.php' ?>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- TOP BAR -->
        <header class="topbar">
            <h1>Employee Dashboard </h1>

            <div class="employee-info">
                <span>Welcome <?php echo $Username." !"; ?> </span>
            </div>
        </header>

        <!-- STATS -->
        <div class="dashboard-cards">
            <div class="card">
                <h3>Documents</h3>
                <p><?php echo $numberDocs; ?></p>
            </div>

        </div>

        <!-- ACTIONS -->
        <div class="actions-bar">

            <a href="newDocument.php" class="add-document-btn">
                + Add Document
            </a>

        </div>
</body>
</html>