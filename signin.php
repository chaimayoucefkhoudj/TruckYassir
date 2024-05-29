<?php
include("./config/db_connect.php");
$message = ""; // Initialize error message variable

if (isset($_POST["submit"])) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $username = $_POST["Username"];
    $password = $_POST["Password"];

    // Query to check if the user exists in the client table
    $clientQuery = "SELECT 'client' AS privilege, id FROM client WHERE name='$username' AND password='$password'";
    $clientResult = mysqli_query($conn, $clientQuery);

    // Query to check if the user exists in the societe table
    $societeQuery = "SELECT 'societe' AS privilege, id FROM societe WHERE Nom='$username' AND password='$password'";
    $societeResult = mysqli_query($conn, $societeQuery);

    if ($clientResult && mysqli_num_rows($clientResult) > 0) {
        $row = mysqli_fetch_assoc($clientResult);
        $privilege = $row['privilege'];
        $userID = $row['id'];

        // Redirect client to client page
        $_SESSION['name'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['privilege'] = $privilege;
        $_SESSION['userID'] = $userID;
        $_SESSION['LogedIn'] = true;
        exit(header("Location: ./client/index.php"));
    } elseif ($societeResult && mysqli_num_rows($societeResult) > 0) {
        $row = mysqli_fetch_assoc($societeResult);
        $privilege = $row['privilege'];
        $userID = $row['id'];

        // Redirect societe to societe page
        $_SESSION['name'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['privilege'] = $privilege;
        $_SESSION['userID'] = $userID;
        $_SESSION['LogedIn'] = true;
        exit(header("Location: ./societe/allCamionslourds.php"));
    } else {
        $message = "Invalid username or password"; // Set error message if no rows are returned
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Truck Yassir</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sign In Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <img src="img/logo.jpg" alt="Truck Yassir Logo" style="width: 100px; height: 100px; border-radius: 50%;">
                            <h4>Connexion</h4>
                        </div>
                        <?php if (!empty($message)) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>
                        <form action="signin.php" method="POST">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="Username" id="floatingInput" placeholder="Name">
                                <label for="floatingInput">Nom d'utilisateur</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="floatingPassword" name="Password" placeholder="Password">
                                <label for="floatingPassword">Mot de passe</label>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary py-3 w-100 mb-4">Se connecter</button>
                        </form>
                        <div class="row">
                            <div class="col text-center">
                                <a href="./signup_client.php" class="btn btn-primary" >Inscription client</a>
                            </div>
                            <div class="col text-center">
                                <a href="./signup_societe.php" class="btn btn-primary" >Inscription société</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign In End -->
    </div>
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/chart/chart.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/tempusdominus/js/moment.min.js"></script>
    <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
