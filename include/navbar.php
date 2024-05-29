<?php
if (isset($_POST["LoginOut"])) {
    session_destroy();
    exit(header("Location: ../signin.php"));
}
?>
<div class="container-xxl position-relative bg-white d-flex flex-column p-0">
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <img src="../img/logo.jpg" alt="Truck Yassir Logo" style="width: 70px; height: 70px; border-radius: 50%;">
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav">
                <?php
                // Display navbar items based on user privilege
                if (isset($_SESSION['privilege'])) {
                    $privilege = $_SESSION['privilege'];
                    if ($privilege == 'societe') {
                        echo '<a href="allCamionslourds.php" class="nav-item nav-link"><i class="fa fa-truck me-2"></i>Camions lourds</a>';
                        echo '<a href="allRemorquesspécialisées.php" class="nav-item nav-link"><i class="fa fa-truck me-2"></i>Remorques</a>';
                        echo '<a href="allCiternes.php" class="nav-item nav-link"><i class="fa fa-truck me-2"></i>Citernes</a>';
                        echo '<a href="alltransportlourd.php" class="nav-item nav-link"><i class="fa fa-truck me-2"></i>transport lourd</a>';
                        echo '<a href="allmarchandises.php" class="nav-item nav-link"><i class="fa fa-archive me-2"></i>marchandises</a>';
                        echo '<a href="neworeder.php" class="nav-item nav-link"><i class="fa fa-paper-plane me-2"></i>Confirmer</a>';
                    } elseif ($privilege == 'client') {
                        echo '<a href="index.php" class="nav-item nav-link"><i class="fa fa-archive me-2"></i>Toutes marchandises</a>';
                        echo '<a href="newMarchandises.php" class="nav-item nav-link"><i class="fa fa-archive me-2"></i>Nouveautés</a>';
                        echo '<a href="allCamionslourds.php" class="nav-item nav-link"><i class="fa fa-truck me-2"></i>Camions lourds</a>';
                        echo '<a href="allRemorquesspécialisées.php" class="nav-item nav-link"><i class="fa fa-truck me-2"></i>Remorques</a>';
                        echo '<a href="allCiternes.php" class="nav-item nav-link"><i class="fa fa-truck me-2"></i>Citernes</a>';
                        echo '<a href="alltransportlourd.php" class="nav-item nav-link"><i class="fa fa-truck me-2"></i>transport lourd</a>';
                        echo '<a href="orders.php" class="nav-item nav-link"><i class="fa fa-paper-plane me-2"></i>Commandes</a>';
                    }
                }
                ?>
            </div>
            <div class="navbar-nav ms-auto">
                <form  method="POST" aria-labelledby="profileDropdown">
                    <button name="LoginOut" class="btn btn-danger m-2" type="Submit">Se déconnecter</button>
                </form>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Rest of your content -->
</div>
