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

// Get the transport ID from the URL
$transportId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch transport data from the database
if ($transportId > 0) {
    $query = "SELECT * FROM transport WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $transportId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $transport = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$transport) {
        die("Transport record not found.");
    }
} else {
    die("Invalid transport ID.");
}

if (isset($_POST['Button_Submit'])) {
    $idSociete = $_SESSION['userID'];
    $type = $_POST['type'];
    $modele = $_POST['modele'];
    $anneeFabrication = $_POST['anneeFabrication'];
    $marque = $_POST['marque'];
    $poids = $_POST['poids'];
    $volume = $_POST['volume'];
    $longueur = $_POST['longueur'];
    $largeur = $_POST['largeur'];
    $hauteur = $_POST['hauteur'];
    $dangereuses = $_POST['dangereuses'];
    $assurance = $_POST['assurance'];
    $driverName = $_POST['driverName'];
    $numeroPermis = $_POST['numeroPermis'];
    $experience = $_POST['experience'];
    $qualifications = $_POST['qualifications'];
    $dossierSecurite = $_POST['dossierSecurite'];
    
    // Handle the image file upload
    if (!empty($_FILES['image']['tmp_name'])) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
    } else {
        // If no new image is uploaded, keep the existing image
        $image = $transport['image'];
    }

    // Update record in the database
    $updateQuery = "UPDATE transport SET image = ?, type = ?, modele = ?, anneeFabrication = ?, marque = ?, poids = ?, volume = ?, longueur = ?, largeur = ?, hauteur = ?, dangereuses = ?, assurance = ?, driverName = ?, numeroPermis = ?, experience = ?, qualifications = ?, dossierSecurite = ? WHERE id = ?";
    $statement = mysqli_prepare($conn, $updateQuery);

    if ($statement === false) {
        die('Prepare failed: ' . htmlspecialchars(mysqli_error($conn)));
    }

    mysqli_stmt_bind_param($statement, "sssisiiddisssssssi", $image, $type, $modele, $anneeFabrication, $marque, $poids, $volume, $longueur, $largeur, $hauteur, $dangereuses, $assurance, $driverName, $numeroPermis, $experience, $qualifications, $dossierSecurite, $transportId);
    $result = mysqli_stmt_execute($statement);

    if ($result) {
        // Transport record updated successfully
        header("Location: ./allCamionslourds.php");
        exit();
    } else {
        // Error occurred while updating record
        echo "Error: " . htmlspecialchars(mysqli_stmt_error($statement));
    }

    mysqli_stmt_close($statement);
}
?>

<?php include_once('../include/header.php'); ?>

<div class="content">
    <!-- Form Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row vh-100 bg-light rounded align-items-center justify-content-center mx-0">
            <div class="col-md-8 col-lg-10 col-xl-8 text-center">
                <div class="bg-light rounded h-100 p-4" style="height: 600px;">
                    <h6 class="mb-4">Modifier Transport id: <?php echo $transport['id'] ; ?></h6>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                            <input type="file" class="form-control" id="image" name="image">
                            <label for="image">Image</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="Remorques à fond bas">Remorques à fond bas</option>
                                <option value="Remorques extensibles">Remorques extensibles</option>
                                <option value="Remorques détachables">Remorques détachables</option>
                                <option value="Remorques citernes">Remorques citernes</option>
                                <option value="Remorques porte-conteneurs">Remorques porte-conteneurs</option>
                                <option value="Remorques de transport de bétail">Remorques de transport de bétail</option>
                                <option value="Remorques de transport de bois">Remorques de transport de bois</option>
                                <option value="Remorques de transport de voitures">Remorques de transport de voitures</option>
                                <option value="Remorques de transport d'équipement lourd">Remorques de transport d'équipement lourd</option>
                            </select>
                            <label for="type">Type</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="modele" name="modele" required>
                                <option value="">Select modele</option>
                                <option value="MaX Trailer SuperMaX Lowboy" <?php echo $transport['modele'] == 'MaX Trailer SuperMaX Lowboy' ? 'selected' : ''; ?>>MaX Trailer SuperMaX Lowboy</option>
                                <option value="Talbert Dura-Plate Extendable Trailer" <?php echo $transport['modele'] == 'Talbert Dura-Plate Extendable Trailer' ? 'selected' : ''; ?>>Talbert Dura-Plate Extendable Trailer</option>
                                <option value="Fruehauf FT-DD Drop Deck Detachable Trailer" <?php echo $transport['modele'] == 'Fruehauf FT-DD Drop Deck Detachable Trailer' ? 'selected' : ''; ?>>Fruehauf FT-DD Drop Deck Detachable Trailer</option>
                                <option value="Stoughton Stainless Steel Tanker Trailer" <?php echo $transport['modele'] == 'Stoughton Stainless Steel Tanker Trailer' ? 'selected' : ''; ?>>Stoughton Stainless Steel Tanker Trailer</option>
                                <option value="Hyundai Translead Container Chassis" <?php echo $transport['modele'] == 'Hyundai Translead Container Chassis' ? 'selected' : ''; ?>>Hyundai Translead Container Chassis</option>
                                <option value="Betts 812 Livestock Trailer" <?php echo $transport['modele'] == 'Betts 812 Livestock Trailer' ? 'selected' : ''; ?>>Betts 812 Livestock Trailer</option>
                                <option value="Load King Super Logger Trailer" <?php echo $transport['modele'] == 'Load King Super Logger Trailer' ? 'selected' : ''; ?>>Load King Super Logger Trailer</option>
                                <option value="Landoll 30 Ton Tag-A-Long Trailer" <?php echo $transport['modele'] == 'Landoll 30 Ton Tag-A-Long Trailer' ? 'selected' : ''; ?>>Landoll 30 Ton Tag-A-Long Trailer</option>
                                <option value="Goldhofer STEPSTAR Self-Propelled Modular Trailer" <?php echo $transport['modele'] == 'Goldhofer STEPSTAR Self-Propelled Modular Trailer' ? 'selected' : ''; ?>>Goldhofer STEPSTAR Self-Propelled Modular Trailer</option>
                            </select>
                            <label for="modele">Modele</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="anneeFabrication" name="anneeFabrication" value="<?php echo htmlspecialchars($transport['anneeFabrication']); ?>" required>
                            <label for="anneeFabrication">Annee Fabrication</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="marque" name="marque" value="<?php echo htmlspecialchars($transport['marque']); ?>" required>
                            <label for="marque">Marque</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="poids" name="poids" value="<?php echo htmlspecialchars($transport['poids']); ?>" required>
                            <label for="poids">Poids (kg)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="volume" name="volume" value="<?php echo htmlspecialchars($transport['volume']); ?>" required>
                            <label for="volume">Volume (m³)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="longueur" name="longueur" value="<?php echo htmlspecialchars($transport['longueur']); ?>" required>
                            <label for="longueur">Longueur (cm)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="largeur" name="largeur" value="<?php echo htmlspecialchars($transport['largeur']); ?>" required>
                            <label for="largeur">Largeur (cm)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="hauteur" name="hauteur" value="<?php echo htmlspecialchars($transport['hauteur']); ?>" required>
                            <label for="hauteur">Hauteur (cm)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="dangereuses" name="dangereuses" required>
                                <option value="no" <?php echo $transport['dangereuses'] == 'no' ? 'selected' : ''; ?>>No</option>
                                <option value="oui" <?php echo $transport['dangereuses'] == 'oui' ? 'selected' : ''; ?>>Oui</option>
                            </select>
                            <label for="dangereuses">Dangereuses</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="assurance" name="assurance" required>
                                <option value="no" <?php echo $transport['assurance'] == 'no' ? 'selected' : ''; ?>>No</option>
                                <option value="oui" <?php echo $transport['assurance'] == 'oui' ? 'selected' : ''; ?>>Oui</option>
                            </select>
                            <label for="assurance">Assurance</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="driverName" name="driverName" value="<?php echo htmlspecialchars($transport['driverName']); ?>" required>
                            <label for="driverName">Driver Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="numeroPermis" name="numeroPermis" value="<?php echo htmlspecialchars($transport['numeroPermis']); ?>" required>
                            <label for="numeroPermis">Numero Permis</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="experience" name="experience" value="<?php echo htmlspecialchars($transport['experience']); ?>" required>
                            <label for="experience">Experience</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="qualifications" name="qualifications" style="height: 100px;" required><?php echo htmlspecialchars($transport['qualifications']); ?></textarea>
                            <label for="qualifications">Qualifications</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="dossierSecurite" name="dossierSecurite" style="height: 100px;" required><?php echo htmlspecialchars($transport['dossierSecurite']); ?></textarea>
                            <label for="dossierSecurite">Dossier Securite</label>
                        </div>
                        <button type="submit" name="Button_Submit" class="btn btn-primary">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Form End -->
</div>

<?php include_once('../include/footer.php'); ?>
