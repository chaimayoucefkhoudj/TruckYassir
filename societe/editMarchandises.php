<?php
include_once('../config/db_connect.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['LogedIn'])) {
    exit(header("Location: ../signin.php"));
} elseif ($_SESSION['privilege'] !== 'societe') {
    exit(header("Location: ../signin.php"));
}

// Step 1: Retrieve id from URL parameter
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    // Step 2: Fetch corresponding marchandises data from the database
    $query = "SELECT * FROM marchandises WHERE id = ?";
    $statement = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($statement, "i", $id);
    mysqli_stmt_execute($statement);
    $result = mysqli_stmt_get_result($statement);
    $marchandises = mysqli_fetch_assoc($result);

    // If no data found, redirect to error page or handle accordingly
    if(!$marchandises) {
        exit(header("Location: error.php"));
    }
}
?>

<?php include_once('../include/header.php'); ?>

<div class="content">
    <!-- Form Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row vh-100 bg-light rounded align-items-center justify-content-center mx-0">
            <div class="col-md-8 col-lg-10 col-xl-8 text-center">
                <div class="bg-light rounded h-100 p-4" style="height: 600px;">
                    
                    <form method="POST">
                        <!-- Populate form fields with fetched data -->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="type" name="type" required value="<?php echo $marchandises['type']; ?>"readonly>
                            <label for="type">Type</label>
                        </div>
                        <!-- Repeat for other fields -->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="description" name="description" required value="<?php echo $marchandises['description']; ?>" readonly>
                            <label for="description">Description</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="poidsTotal" name="poidsTotal" required value="<?php echo $marchandises['poidsTotal']; ?>"readonly>
                            <label for="poidsTotal">Poids Total (kg)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="volumeTotal" name="volumeTotal" required value="<?php echo $marchandises['volumeTotal']; ?>"readonly>
                            <label for="volumeTotal">Volume Total (m³)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="placeChargement" name="placeChargement" required value="<?php echo $marchandises['placeChargement']; ?>"readonly>
                            <label for="placeChargement">Place de Chargement</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="placeDechargement" name="placeDechargement" required value="<?php echo $marchandises['placeDechargement']; ?>"readonly>
                            <label for="placeDechargement">Place de Déchargement</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="note" name="note" required><?php echo $marchandises['note']; ?></textarea>
                            <label for="note">Note</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="dateChargement" name="dateChargement" required value="<?php echo $marchandises['dateChargement']; ?>"readonly>
                            <label for="dateChargement">Date de Chargement</label>
                        </div>
                        <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="placeDechargement" name="placeDechargement" required value="<?php echo $marchandises['typeDeMoyen']; ?>"readonly>
                            <label for="typeDeMoyen">Type de Moyen</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="budget" name="budget" required value="<?php echo $marchandises['budget']; ?>"readonly>
                            <label for="budget">Budget (€)</label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Form End -->
</div>

<?php include_once('../include/footer.php'); ?>