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

if (isset($_POST['Button_Submit'])) {
    // Retrieve form data
    $idTransport = intval($_POST['idTransport']);
    $idMarchandises = intval($_POST['idMarchandises']);

    // Start a transaction
    mysqli_begin_transaction($conn);

    try {
        // Insert record into the orders table
        $insertQuery = "INSERT INTO orders (idTransport, idMarchandises) VALUES (?, ?)";
        $statement = mysqli_prepare($conn, $insertQuery);
        if ($statement === false) {
            throw new Exception('Prepare failed: ' . htmlspecialchars(mysqli_error($conn)));
        }

        mysqli_stmt_bind_param($statement, "ii", $idTransport, $idMarchandises);
        if (!mysqli_stmt_execute($statement)) {
            throw new Exception('Execute failed: ' . htmlspecialchars(mysqli_stmt_error($statement)));
        }
        mysqli_stmt_close($statement);

        // Update state of transport
        $updateTransportQuery = "UPDATE transport SET state = 0 WHERE id = ?";
        $stmtTransport = mysqli_prepare($conn, $updateTransportQuery);
        if ($stmtTransport === false) {
            throw new Exception('Prepare failed: ' . htmlspecialchars(mysqli_error($conn)));
        }

        mysqli_stmt_bind_param($stmtTransport, "i", $idTransport);
        if (!mysqli_stmt_execute($stmtTransport)) {
            throw new Exception('Execute failed: ' . htmlspecialchars(mysqli_stmt_error($stmtTransport)));
        }
        mysqli_stmt_close($stmtTransport);

        // Update state of marchandises
        $updateMarchandisesQuery = "UPDATE marchandises SET state = 0 WHERE id = ?";
        $stmtMarchandises = mysqli_prepare($conn, $updateMarchandisesQuery);
        if ($stmtMarchandises === false) {
            throw new Exception('Prepare failed: ' . htmlspecialchars(mysqli_error($conn)));
        }

        mysqli_stmt_bind_param($stmtMarchandises, "i", $idMarchandises);
        if (!mysqli_stmt_execute($stmtMarchandises)) {
            throw new Exception('Execute failed: ' . htmlspecialchars(mysqli_stmt_error($stmtMarchandises)));
        }
        mysqli_stmt_close($stmtMarchandises);

        // Commit the transaction
        mysqli_commit($conn);

        // Redirect to index page after successful insertion
        header("Location: ./allCamionslourds.php");
        exit();
    } catch (Exception $e) {
        // Rollback the transaction if something went wrong
        mysqli_rollback($conn);
        echo "Error: " . $e->getMessage();
    }
}
?>

<?php include_once('../include/header.php'); ?>

<div class="content">
    <!-- Form Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row vh-100 bg-light rounded align-items-center justify-content-center mx-0">
            <div class="col-md-8 col-lg-10 col-xl-8 text-center">
                <div class="bg-light rounded h-100 p-4">
                    <h6 class="mb-4">Confirmer la commande</h6>
                    <form method="POST">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="idTransport" name="idTransport" required>
                            <label for="idTransport">ID Transport</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="idMarchandises" name="idMarchandises" required>
                            <label for="idMarchandises">ID Marchandises</label>
                        </div>
                        <div class="mt-4">
                            <button type="submit" name="Button_Submit" class="btn btn-primary">Envyoer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Form End -->
</div>

<?php include_once('../include/footer.php'); ?>
