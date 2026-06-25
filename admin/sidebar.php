<?php
    $queryPic = "SELECT photo FROM users WHERE id=$UserId";
    $resultPic = mysqli_query($connection, $queryPic);
    $pic = mysqli_fetch_array($resultPic);
?>


<head>
    <link rel="stylesheet" href="admin.css">
</head>

    <aside class="sidebar">
        <h2 class="sidebar-logo">KeepDocs</h2>

        <div class="sidebar-photo-circle">
                    <?php if(!empty($pic['photo'])): ?>
                        <img id="preview" src="uploads/<?php echo $pic['photo']; ?>"
                             alt="Profile Photo">
                    <?php else: ?>
                        <img id="preview" src="../images/anonym.png" alt="Default Photo">
                    <?php endif; ?>
        </div>

        <nav class="sidebar-nav">
            <a href="admin.php" class="active">Dashboard</a>
            <a href="profile.php">Profile</a>
            <a href="service.php">Services</a>
            <a href="user.php">Employees</a>
            <a href="document.php">Documents</a>
        </nav>

        <a href="../disconnect.php" class="logout-btn">Logout</a>
    </aside>

  