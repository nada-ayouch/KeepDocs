<?php
require '../dbconnect.php';
require '../session.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    die("Missing ID");
}

$page = $_POST['page'] ?? 1;

$query = "SELECT * FROM users WHERE id=$id";
$result = mysqli_query($connection, $query);
$user = mysqli_fetch_array($result);

if (
    isset(
        $_POST['firstName'],
        $_POST['lastName'],
        $_POST['email'],
        $_POST['gender'],
        $_POST['serviceId'],
        $_POST['role']
    )
) {

    $userFirstName = mysqli_real_escape_string($connection,$_POST['firstName']);
    $userLastName = mysqli_real_escape_string($connection,$_POST['lastName']);
    $userEmail = mysqli_real_escape_string($connection,$_POST['email']);
    $userGender = mysqli_real_escape_string($connection,$_POST['gender']);
    $userServiceId = mysqli_real_escape_string($connection,$_POST['serviceId']);
    $userRole = mysqli_real_escape_string($connection,$_POST['role']);

    $query = "UPDATE users 
              SET firstName='$userFirstName',
                  lastName='$userLastName',
                  email='$userEmail',
                  gender='$userGender',
                  serviceId='$userServiceId',
                  role ='$userRole'
              WHERE id=$id";

    $nb = mysqli_query($connection, $query);

    if ($nb) {
        header("Location: user.php?page=".$page);
        exit;
    } else {
        echo "Error: " . mysqli_error($connection);
    }

}
?>

<!DOCTYPE html>
<html lang="en">
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
            <span>Welcome <?php echo $Username . " !"; ?></span>
        </div>
    </header>

    <div class="back-container">
        <a href="user.php" class="back-btn">← Back</a>
    </div>

    <form class="user-container" method="POST">

        <!-- Hidden ID -->
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <input type="hidden" name="page" value="<?php echo $page; ?>">

        <h1 class="user-title">Update User</h1>

        <div class="user-form">

            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="firstName" value="<?php echo $user['firstName']; ?>">
            </div>

            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="lastName" value="<?php echo $user['lastName']; ?>">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?php echo $user['email']; ?>">
            </div>

            <div class="form-group">
                <label>Gender</label>

                <select name="gender">

                    <option value="male" <?php if ($user['gender'] == 'male') echo 'selected'; ?>>
                        Male
                    </option>

                    <option value="female" <?php if ($user['gender'] == 'female') echo 'selected'; ?>>
                        Female
                    </option>

                </select>
            </div>

            <div class="form-group">
                <label>Service</label>

                <?php
                // Récupérer tous les services depuis la base de données
                $subquery = "SELECT * FROM service";
                $subresult = mysqli_query($connection, $subquery);
                ?>
                <!-- Liste déroulante des services -->
                <select name="serviceId">

                    <?php while($service = mysqli_fetch_assoc($subresult)): ?>
                        <option value="<?php echo $service['id']; ?>"
                            <?php if ($user['serviceId'] == $service['id']) echo 'selected'; ?>>
                            <?php echo $service['name']; ?>
                        </option>
                    <?php endwhile; ?>

                </select>
            </div>

            <div class="form-group">
                <label>Role</label>

                <select name="role">

                    <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>
                        Admin
                    </option>

                    <option value="employee" <?php if ($user['role'] == 'employee') echo 'selected'; ?>>
                        Employee
                    </option>

                </select>
            </div>

        </div>

        <button type="submit" class="user-btn">Update</button>

    </form>

</main>

</body>
</html>

<?php
mysqli_close($connection);
?>