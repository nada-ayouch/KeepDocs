<?php

require '../dbconnect.php';
require '../session.php';

$query = "SELECT
            id,
            title,
            description,
            doctype,
            name,
            file,
            uploadDate
          FROM documents 
          where userId= $UserId";

$result = mysqli_query($connection, $query);
$numDocs = mysqli_num_rows($result);

$counter = 0;

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
            <h1>Documents</h1>

            <div class="employee-info">
                <span>Welcome <?php echo $Username." !"; ?> </span>
            </div>
        </header>


        <!-- TABLE SERVICES -->
    <div class="table-container">

        <table class="services-table">

            <thead>
                <tr>

                    <th>N°</th>
                    <th>File</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Type
                        <select id="filterType">
                            <option value="">All</option>
                            <option value="pdf">PDF</option>
                            <option value="word">Word</option>
                            <option value="excel">Excel</option>
                            <option value="powerpoint">PowerPoint</option>
                        </select>
                    </th>

                    <th>Upload Date <span><input type="date" id="filterDate"></th>
                    <th>Action</th>
                </tr>
            </thead>
                
            <tbody>
                <?php if ($result && $numDocs > 0): ?>
                    <?php  while ($doc = mysqli_fetch_array($result)):?>
                    <?php $counter++ ?> 
                    <tr>
                        <td><?php echo $counter;?></td>  
                        <td><a href="<?php echo $doc['file']; ?>"
                        download="<?php echo $doc['name']; ?>">📄</a></td>
                        <td><?php echo $doc['title'];?></td> 
                        <td><?php echo $doc['description'];?></td>
                        <td><?php echo $doc['doctype'];?></td> 
                        <td data-date="<?php echo date('Y-m-d', strtotime($doc['uploadDate'])); ?>">
                            <span class="badge valide">
                                <?php echo date("d M Y", strtotime($doc['uploadDate'])); ?>
                            </span>
                        </td>
                        
                        <td>
                                <form action="delete.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $doc['id']; ?>">
                                <button type="submit" class="butn butn-danger" onclick =" return confirm('do you want to delete ?')">🗑️</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
                <?php endif; ?>
            </tbody>

        </table>

        
    </main>



</body>


<script>
// Exécuter le filtre lorsque le type ou la date change
document.getElementById("filterType").addEventListener("change", filterTable);
document.getElementById("filterDate").addEventListener("change", filterTable);

// Fonction de filtrage 
function filterTable()
{
    // Déclaration de deux variables locales pour stocker le type et la date sélectionnés
    let type = document.getElementById("filterType").value.toLowerCase(); 
    let date = document.getElementById("filterDate").value;
    
    // Déclaration d'une variable contenant toutes les lignes du tableau
    let rows = document.querySelectorAll("tbody tr");
    //On parcourt ensuite chaque ligne du tableau grâce à la méthode foreach.
    rows.forEach(function(row){
        // Récupérer le type du document dans la 5ème colonne et le convertir en minuscules
        let docType = row.cells[4].textContent.toLowerCase();
        let docDate = row.cells[5].getAttribute("data-date"); //récupère la valeur d'un attribut HTML.

        let show = true;
        
        // Vérifier si le type du document correspond au filtre sélectionné
        if(type && docType !== type)
        {
            show = false;
        }

        if(date && docDate !== date)
        {
            show = false;
        }
    //Afficher ou masquer la ligne selon le résultat du filtrage
        row.style.display = show ? "" : "none";
    });
}
</script>

</html>