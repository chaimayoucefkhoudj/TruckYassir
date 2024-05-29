<?php
include_once('../config/db_connect.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['LogedIn'])) {
    exit(header("Location: ../signin.php"));
} elseif ($_SESSION['privilege'] !== 'client') {
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

if (isset($_POST['Button_Submit'])) {
    // Retrieve form data
    $type = $_POST['type'];
    $description = $_POST['description'];
    $poidsTotal = $_POST['poidsTotal'];
    $volumeTotal = $_POST['volumeTotal'];
    $placeChargement = $_POST['placeChargement'];
    $placeDechargement = $_POST['placeDechargement'];
    $note = $_POST['note'];
    $dateChargement = $_POST['dateChargement'];
    $typeDeMoyen = $_POST['typeDeMoyen'];
    $budget = $_POST['budget'];
    $idClient = $_SESSION['userID']; // Assuming the client ID is stored in the session

    // Step 5: Update record in the database
    $updateQuery = "UPDATE marchandises SET type=?, description=?, poidsTotal=?, volumeTotal=?, placeChargement=?, placeDechargement=?, note=?, dateChargement=?, typeDeMoyen=?, budget=? WHERE id=?";
    $statement = mysqli_prepare($conn, $updateQuery);
    // Bind parameters
    mysqli_stmt_bind_param($statement, "ssiissssssi", $type, $description, $poidsTotal, $volumeTotal, $placeChargement, $placeDechargement, $note, $dateChargement, $typeDeMoyen, $budget, $id);
    $result = mysqli_stmt_execute($statement);

    if ($result) {
        // Record updated successfully
        exit(header("Location: ./index.php")); // Redirect to a page to view all marchandises
    } else {
        // Error occurred while updating record
        echo "Error: " . mysqli_error($conn);
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
                    <h6 class="mb-4">Modifier marchandise id: <?php echo $marchandises['id']; ?> </h6>
                    <form method="POST">
                        <!-- Populate form fields with fetched data -->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="type" name="type" required value="<?php echo $marchandises['type']; ?>">
                            <label for="type">Type</label>
                        </div>
                        <!-- Repeat for other fields -->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="description" name="description" required value="<?php echo $marchandises['description']; ?>">
                            <label for="description">Description</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="poidsTotal" name="poidsTotal" required value="<?php echo $marchandises['poidsTotal']; ?>">
                            <label for="poidsTotal">Poids Total (kg)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="volumeTotal" name="volumeTotal" required value="<?php echo $marchandises['volumeTotal']; ?>">
                            <label for="volumeTotal">Volume Total (m³)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="placeChargement" name="placeChargement" required value="<?php echo $marchandises['placeChargement']; ?>">
                            <label for="placeChargement">Place de Chargement</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="placeDechargement" name="placeDechargement" required value="<?php echo $marchandises['placeDechargement']; ?>">
                            <label for="placeDechargement">Place de Déchargement</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="note" name="note" required><?php echo $marchandises['note']; ?></textarea>
                            <label for="note">Note</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="dateChargement" name="dateChargement" required value="<?php echo $marchandises['dateChargement']; ?>">
                            <label for="dateChargement">Date de Chargement</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-control" id="typeDeMoyen" name="typeDeMoyen" required>
                                <option value="<?php echo $marchandises['typeDeMoyen']; ?>" selected><?php echo $marchandises['typeDeMoyen']; ?></option>
                                <option value="Camions lourds">Camions lourds</option>
                                <option value="Citernes">Citernes</option>
                                <option value="transport lourd">transport lourd</option>
                                <option value="Remorques spécialisées">Remorques spécialisées</option>
                            </select>
                            <label for="typeDeMoyen">Type de Moyen</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="budget" name="budget" required value="<?php echo $marchandises['budget']; ?>">
                            <label for="budget">Budget (€)</label>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $marchandises['id']; ?>">
                        <div class="mt-4">
                            <button type="submit" name="Button_Submit" class="btn btn-primary">Envoyer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Form End -->
</div>

<?php include_once('../include/footer.php'); ?>