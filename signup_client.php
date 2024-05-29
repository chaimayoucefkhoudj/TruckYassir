<?php
include("./config/db_connect.php");
$message = ""; // Initialize error message variable

if (isset($_POST["submit"])) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $numeroTelephone = mysqli_real_escape_string($conn, $_POST["numeroTelephone"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $adresse = mysqli_real_escape_string($conn, $_POST["adresse"]);

    // Check if email already exists
    $checkQuery = "SELECT * FROM client WHERE email='$email'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        $message = "Email already exists"; // Set error message if email already exists
    } else {
        // Insert new client into the client table
        $query = "INSERT INTO client (name, numeroTelephone, email, password, adresse) 
                  VALUES ('$name', '$numeroTelephone', '$email', '$password', '$adresse')";
        if (mysqli_query($conn, $query)) {
            exit(header("Location: ./signin.php")); // Redirect to client page after successful signup
        } else {
            $message = "Signup failed"; // Set error message if query fails
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Client Signup</title>
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
        <!-- Sign Up Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h3 class="text-primary"><i class="fa fa-archive me-2"></i>Inscription du client</h3>
                        </div>
                        <?php if (!empty($message)) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>
                        <form action="signup_client.php" method="POST">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="name" id="floatingName" placeholder="Name" required>
                                <label for="floatingName">Nom</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="numeroTelephone" id="floatingPhone" placeholder="Phone Number" required>
                                <label for="floatingPhone">Numéro du Téléphone</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" name="email" id="floatingEmail" placeholder="Email" required>
                                <label for="floatingEmail">Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password" required>
                                <label for="floatingPassword">Mot de passe</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="adresse" id="floatingAddress" placeholder="Address" required>
                                <label for="floatingAddress">Addresse</label>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary py-3 w-100 mb-4">Inscription</button>
                        </form>
                        <div class="text-center">
                            <a href="signin.php" class="btn btn-link">Avez vous déja un compte ? Se connecter</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign Up End -->
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
