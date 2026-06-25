<?php

// Connexion à la base de données et récupération de la session utilisateur
require '../dbconnect.php';
require '../session.php';

// Vérifier si le formulaire a été soumis
if(isset($_POST['upload']))
{
    // Récupérer les données du formulaire
    $title = $_POST['title'];
    $description = $_POST['description'];
    $doctype = $_POST['doctype'];

    // Vérifier qu'un fichier a été sélectionné
    if($_FILES['file']['error'] != 0)
    {
        echo "<script>
            alert('Please select a file.');
            window.history.back();
          </script>";
        exit();
    }

    // Récupérer l'extension du fichier uploadé
    $extension = strtolower(
        pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION)
    );

    // Variable permettant de vérifier la validité du type de fichier
    $valid = false;

    // Vérifier la correspondance entre le type choisi et l'extension du fichier
    if($doctype == "pdf" && $extension == "pdf")
    {
        $valid = true;
    }
    elseif($doctype == "word" && ($extension == "doc" || $extension == "docx"))
    {
        $valid = true;
    }
    elseif($doctype == "excel" && ($extension == "xls" || $extension == "xlsx"))
    {
        $valid = true;
    }
    elseif($doctype == "powerpoint" && ($extension == "ppt" || $extension == "pptx"))
    {
        $valid = true;
    }

    // Afficher un message d'erreur si le type ne correspond pas au fichier
    if(!$valid)
    {
        echo "<script>
            alert('The selected type does not match the uploaded file.');
            window.history.back();
          </script>";
        exit();
    }

    // Générer un nom unique pour éviter les doublons
    $fileName = uniqid() . "_" . $_FILES['file']['name'];

    // Définir le chemin de stockage du fichier
    $filePath = "uploadsFile/" . $fileName;

    // Créer le nom affiché du document
    $displayName = $title . "." . $extension;

    // Déplacer le fichier depuis son emplacement temporaire vers le dossier uploadsFile
    move_uploaded_file($_FILES['file']['tmp_name'], $filePath);

    // Sécuriser les données avant l'insertion dans la base de données
    $title = mysqli_real_escape_string($connection, $title);
    $description = mysqli_real_escape_string($connection, $description);
    $doctype = mysqli_real_escape_string($connection, $doctype);
    $displayName = mysqli_real_escape_string($connection, $displayName);

    // Enregistrer les informations du document dans la base de données
    $query = "INSERT INTO documents
    (title, description, doctype, userId, `file`, name)
    VALUES('$title', '$description', '$doctype', '$UserId', '$filePath', '$displayName')";

    $result = mysqli_query($connection, $query);

    // Rediriger vers la page des documents si l'ajout réussit
    if($result)
    {
        header("Location: documents.php");
        exit();
    }
    else
    {
        // Afficher l'erreur SQL en cas d'échec
        echo mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Document - KeepDocs</title>
    <link rel="stylesheet" href="employee.css">
</head>

<body class="archive-body">

   <?php include 'sidebar.php' ?>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- TOP BAR -->
        <header class="topbar">
            <h1>Document</h1>

            <div class="employee-info">
                <span>Welcome <?php echo $Username." !"; ?> </span>
            </div>
        </header>

    

        <div class="archive-container">

            <div class="archive-header">
                <div class="archive-icon"> 📂 </div>
                <h1>Add New Archive</h1>
                <p>Store and organize your important documents</p>
                </div>

                <div  class="back-btn">
                    <a href="employee.php">⟵ Back</a>
                </div>

            <form class="archive-form" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                <label>Document Title</label>
                <input type="text" name=title placeholder="Enter document title">
                </div>

           
            <div class="form-group">
                <label>Document Type</label>
                <select name=doctype>
                    <option value=0>Select type</option>
                    <option value="pdf">PDF</option>
                    <option value="excel">Excel</option>
                    <option value="word">Word</option>
                    <option value="powerpoint">PowerPoint</option>
                </select>
            </div>


        
             <div class="form-group">
                <label >Description</label>
                <textarea name="description" placeholder="Write document description"></textarea>
            </div>
            
            <div class="upload-box">
            <div class="upload-left">
                <div class="upload-icon">📄</div>
            <div>

            <p class="upload-text">Upload your document</p>
            <span class="upload-subtext">PDF, Word, Excel or PowerPoint</span>

        </div>

    </div>

            <input type="file" id="file" name="file">
            <label for="file" class="upload-btn"> Browse File </label>

        </div>
            <button type="submit" name="upload" class="submit-btn"> Save Archive </button>
        </form>
        </div>

</body>
</html>