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
    $idSociete = $_SESSION['userID'];
    $image = file_get_contents($_FILES['image']['tmp_name']);
    $category = "transport lourd";
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

    // Insert record into database
    $insertQuery = "INSERT INTO transport (idSociete, image, type, modele, anneeFabrication, marque, poids, volume, longueur, largeur, hauteur, dangereuses, assurance, driverName, numeroPermis, experience, qualifications, category, dossierSecurite) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $statement = mysqli_prepare($conn, $insertQuery);

    if ($statement === false) {
        die('Prepare failed: ' . htmlspecialchars(mysqli_error($conn)));
    }

    // Bind parameters
    mysqli_stmt_bind_param($statement, "isssisiiddissssssss", $idSociete, $image, $type, $modele, $anneeFabrication, $marque, $poids, $volume, $longueur, $largeur, $hauteur, $dangereuses, $assurance, $driverName, $numeroPermis, $experience, $qualifications, $category, $dossierSecurite);
    $result = mysqli_stmt_execute($statement);

    if ($result) {
        // Transport record inserted successfully
        header("Location: ./allCamionslourds.php");
        exit();
    } else {
        // Error occurred while inserting record
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
                    <h6 class="mb-4">Ajouter un transport lourd</h6>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-floating mb-3">
                            <input type="file" class="form-control" id="image" name="image" required>
                            <label for="image">Image</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="Camions de remorquage lourds">Camions de remorquage lourds</option>
                                <option value="Grues mobiles">Grues mobiles</option>
                                <option value="Transporteurs multi-axes">Transporteurs multi-axes</option>
                                <option value="Véhicules de transport multi-axes tout-terrain">Véhicules de transport multi-axes tout-terrain</option>
                            </select>
                            <label for="type">Type</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="modele" name="modele" required>
                                <option value="">Select modele</option>
                                <option value="Kenworth T900">Kenworth T900</option>
                                <option value="Peterbilt 360">Peterbilt 360</option>
                                <option value="Caterpillar 797F Haul Truck">Caterpillar 797F Haul Truck</option>
                                <option value="Liebherr LTM 1750-2.1 Mobile Crane">Liebherr LTM 1750-2.1 Mobile Crane</option>
                                <option value="Scheuerle SPM 40T Multi-Axle Transporter">Scheuerle SPM 40T Multi-Axle Transporter</option>
                                <option value="Oshkosh M1070A1 HET">Oshkosh M1070A1 HET</option>
                                <option value="Terex AC 650/50 All Terrain Crane">Terex AC 650/50 All Terrain Crane</option>
                                <option value="Manitowoc MLC600 Crawler Crane">Manitowoc MLC600 Crawler Crane</option>
                            </select>
                            <label for="modele">Modele</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="anneeFabrication" name="anneeFabrication" required>
                            <label for="anneeFabrication">Annee Fabrication</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="marque" name="marque" required>
                            <label for="marque">Marque</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="poids" name="poids" required>
                            <label for="poids">Poids (kg)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="volume" name="volume" required>
                            <label for="volume">Volume (m³)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="longueur" name="longueur" required>
                            <label for="longueur">Longueur (cm)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="largeur" name="largeur" required>
                            <label for="largeur">Largeur (cm)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="hauteur" name="hauteur" required>
                            <label for="hauteur">Hauteur (cm)</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="dangereuses" name="dangereuses" required>
                                <option value="no">Non</option>
                                <option value="oui">Oui</option>
                            </select>
                            <label for="dangereuses">Dangereuses</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="assurance" name="assurance" required>
                                <option value="no">Non</option>
                                <option value="oui">Oui</option>
                            </select>
                            <label for="assurance">Assurance</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="driverName" name="driverName" required>
                            <label for="driverName">Nom du conducteur</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="numeroPermis" name="numeroPermis" required>
                            <label for="numeroPermis">Numero Permis</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="experience" name="experience" required>
                            <label for="experience">Experience</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="qualifications" name="qualifications" required>
                            <label for="qualifications">Qualifications</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="dossierSecurite" name="dossierSecurite" required>
                            <label for="dossierSecurite">Dossier Securite</label>
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
