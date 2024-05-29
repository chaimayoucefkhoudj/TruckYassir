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

// Handle Deactivate button click
if (isset($_GET['Deactivate_id'])) {
    $id = $_GET['Deactivate_id'];
    // Fetch the current state
    $stateQuery = "SELECT state FROM marchandises WHERE id = ?";
    $stateStatement = mysqli_prepare($conn, $stateQuery);
    mysqli_stmt_bind_param($stateStatement, "i", $id);
    mysqli_stmt_execute($stateStatement);
    $stateResult = mysqli_stmt_get_result($stateStatement);
    $marchandise = mysqli_fetch_assoc($stateResult);

    if ($marchandise) {
        $newState = $marchandise['state'] == 1 ? 0 : 1;
        // Update the state
        $updateQuery = "UPDATE marchandises SET state = ? WHERE id = ?";
        $updateStatement = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($updateStatement, "ii", $newState, $id);
        mysqli_stmt_execute($updateStatement);
    }
}

// Fetch marchandises for the logged-in client
$clientId = $_SESSION['userID'];
$marchandisesQuery = "SELECT * FROM marchandises WHERE idClient = ?";
$marchandisesStatement = mysqli_prepare($conn, $marchandisesQuery);
mysqli_stmt_bind_param($marchandisesStatement, "i", $clientId);
mysqli_stmt_execute($marchandisesStatement);
$marchandisesResult = mysqli_stmt_get_result($marchandisesStatement);

?>

<?php include_once('../include/header.php'); ?>

<div class="container-fluid pt-4 px-4">
    <div class="row">
        <h2>Vos Marchandises</h2>
        <?php
        if ($marchandisesResult && mysqli_num_rows($marchandisesResult) > 0) {
            while ($marchandise = mysqli_fetch_assoc($marchandisesResult)) {
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Type: <?php echo htmlspecialchars($marchandise['type']); ?></h5>
                            <p>Description: <?php echo htmlspecialchars($marchandise['description']); ?></p>
                            <p>Poids Total: <?php echo htmlspecialchars($marchandise['poidsTotal']); ?> kg</p>
                            <p>Volume Total: <?php echo htmlspecialchars($marchandise['volumeTotal']); ?> m³</p>
                            <p>Place de Chargement: <?php echo htmlspecialchars($marchandise['placeChargement']); ?></p>
                            <p>Place de Déchargement: <?php echo htmlspecialchars($marchandise['placeDechargement']); ?></p>
                            <p>Date de Chargement: <?php echo htmlspecialchars($marchandise['dateChargement']); ?></p>
                            <p>Type de Moyen: <?php echo htmlspecialchars($marchandise['typeDeMoyen']); ?></p>
                            <p>Budget: <?php echo htmlspecialchars($marchandise['budget']); ?> DA</p>
                            <p>État: 
                                <span class="badge 
                                    <?php echo $marchandise['state'] == 1 ? 'bg-success' : 'bg-danger'; ?>">
                                    <?php echo $marchandise['state'] == 1 ? 'Active' : 'Désactivée'; ?>
                                </span>
                            </p>
                            <div class="btn-group" role="group">
                                <a href="editMarchandises.php?id=<?php echo $marchandise['id']; ?>" class="btn btn-primary">Modifier</a>
                                <a href="?Deactivate_id=<?php echo $marchandise['id']; ?>" class="btn btn-danger"><?php echo $marchandise['state'] == 1 ? 'Deactiver' : 'Activer'; ?></a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<p>No marchandises found</p>";
        }
        ?>
    </div>
</div>

<?php include_once('../include/footer.php'); ?>
