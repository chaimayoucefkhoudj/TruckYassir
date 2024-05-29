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

if (isset($_POST['Button_Submit'])) {
    // Retrieve form data
    $type = $_POST['type'];
    $description = $_POST['description'];
    $poidsTotal = $_POST['poidsTotal'];
    $volumeTotal = $_POST['volumeTotal'];
    $placeChargement = $_POST['placeChargement'];
    $placeDechargement = $_POST['placeDechargement'];
    $traitementParticulier = $_POST['traitementParticulier'];
    $note = $_POST['note'];
    $dateChargement = $_POST['dateChargement'];
    $typeDeMoyen = $_POST['typeDeMoyen'];
    $budget = $_POST['budget'];
    $idClient = $_SESSION['userID']; // Assuming the client ID is stored in the session

    // Insert record into database
    $insertQuery = "INSERT INTO marchandises (idClient, type, description, poidsTotal, volumeTotal, placeChargement, placeDechargement, note, dateChargement, typeDeMoyen, budget,traitementParticulier) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
    $statement = mysqli_prepare($conn, $insertQuery);
    // Bind parameters
    mysqli_stmt_bind_param($statement, "issiisssssss", $idClient, $type, $description, $poidsTotal, $volumeTotal, $placeChargement, $placeDechargement, $note, $dateChargement, $typeDeMoyen, $budget,$traitementParticulier);
    $result = mysqli_stmt_execute($statement);

    if ($result) {
        // Record inserted successfully
        exit(header("Location: ./index.php")); // Redirect to a page to view all marchandises
    } else {
        // Error occurred while inserting record
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
                    <h6 class="mb-4">Ajouter nouveau marchandise</h6>
                    <form method="POST">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="type" name="type" required>
                            <label for="type">Type</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="description" name="description" required>
                            <label for="description">Description</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="poidsTotal" name="poidsTotal" required>
                            <label for="poidsTotal">Poids Total (kg)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="volumeTotal" name="volumeTotal" required>
                            <label for="volumeTotal">Volume Total (m³)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="placeChargement" name="placeChargement" required>
                            <label for="placeChargement">Place de Chargement</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="placeDechargement" name="placeDechargement" required>
                            <label for="placeDechargement">Place de Déchargement</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="traitementParticulier" name="traitementParticulier" required></textarea>
                            <label for="traitementParticulier">Traitement Particulier</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="dateChargement" name="dateChargement" required>
                            <label for="dateChargement">Date de Chargement</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-control" id="typeDeMoyen" name="typeDeMoyen" required>
                                <option value="">Sélectioner type de moyen de transport</option>
                                <option value="Camions lourds">Camions lourds</option>
                                <option value="Citernes">Citernes</option>
                                <option value="transport lourd">transport lourd</option>
                                <option value="Remorques spécialisées">Remorques spécialisées</option>
                            </select>
                            <label for="typeDeMoyen">Type de Moyen</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="budget" name="budget" required>
                            <label for="budget">Budget</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="note" name="note" required></textarea>
                            <label for="note">Informations</label>
                        </div>
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