<?php

require '../dbconnect.php';
require '../session.php';

$criterion = $_GET['criterion'] ?? "";

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if($page < 1)
{
    $page = 1;
}

$limit = 5;
$start = ($page - 1) * $limit;


// Requête principale
$query = "SELECT d.id,
                 d.title,
                 d.description,
                 d.doctype,
                 d.name,
                 d.file,
                 d.uploadDate,
                 u.firstName,
                 u.lastName
          FROM documents d
          JOIN users u ON d.userId = u.id";


// Recherche
if($criterion != "")
{
    $query .= " WHERE d.title LIKE '%$criterion%'
                OR d.description LIKE '%$criterion%'";
}


// Compter le nombre total de documents
$countQuery = "SELECT COUNT(*) AS total
               FROM documents";

if($criterion != "")
{
    $countQuery .= " WHERE title LIKE '%$criterion%'
                     OR description LIKE '%$criterion%'";
}

$countResult = mysqli_query($connection, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);

$totalDocs = $countRow['total'];
$totalPages = ceil($totalDocs / $limit);


// Ajouter la pagination
$query .= " LIMIT $start, $limit";

$result = mysqli_query($connection, $query);

$counter = $start;
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documents - KeepDocs</title>
    <link rel="stylesheet" href="employee.css">
</head>

<body class="admin-body">

   <?php include 'sidebar.php' ?>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- TOP BAR -->
        <header class="topbar">
            <h1>Documents</h1>

            <div class="employee-info">
                <span>Welcome <?php echo $Username." !"; ?> </span>
            </div>
        </header>

        <form class="search-form" method="GET">
            <input type="text" name="criterion" placeholder="Rechercher..." value = "<?php  echo $criterion; ?>">
            <button type="submit">Search</button>
        </form>

        <!-- TABLE SERVICES -->
    <div class="table-container">

        <table class="services-table">

            <thead>
                <tr>
                    <th>N°</th>
                    <th>File</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th>Upload date</th>
                    <th>User</th>
                    <th colspan=2>Action</th>
                </tr>
            </thead>
                
            <tbody>
                <?php if($result && mysqli_num_rows($result) > 0): ?>
                    <?php  while ($doc = mysqli_fetch_array($result)):?>
                    <?php $counter++ ?> 
                    <tr>
                        <td><?php echo $counter;?></td>  
                        <td><a href="<?php echo $doc['file']; ?>"
                        download="<?php echo $doc['name']; ?>">📄</a></td>
                        <td><?php echo $doc['title'];?></td> 
                        <td><?php echo $doc['description'];?></td>
                        <td><?php echo $doc['doctype'];?></td> 
                        <td><span class="badge valide"><?php echo date("d M Y", strtotime($doc['uploadDate']));?></span></td>
                        <td><?php echo $doc['firstName'].' '.$doc['lastName']; ?></td>
                        <td>
                            <form action="deleteDoc.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $doc['id']; ?>">
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
                echo "<a class='$active' href='?page=$i&criterion=$criterion'>$i</a>";
            }
            ?>
        </div>
    
    </main>

</body>
</html>