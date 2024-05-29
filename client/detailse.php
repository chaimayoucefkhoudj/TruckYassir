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

// Get the transport ID from the URL
$transportId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch transport data from the database
if ($transportId > 0) {
    $query = "SELECT t.*, s.Nom AS societeNom, s.NumeroLicence, s.adresse, s.numeroTelephone, s.email, s.siteWeb, s.assurance AS societeAssurance 
              FROM transport t 
              JOIN societe s ON t.idSociete = s.id 
              WHERE t.id = ?";
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
?>

<?php include_once('../include/header.php'); ?>

<div class="content">
    <div class="container-fluid pt-4 px-4">
        <div class="row vh-100 bg-light rounded align-items-center justify-content-center mx-0">
            <div class="col-md-8 col-lg-10 col-xl-8 text-center">
                <div class="bg-light rounded h-100 p-4" style="height: 600px;">
                    <h6 class="mb-4"> Information  sur le type de transport </h6>
                    <div class="mb-3">
                        <?php $imageData = base64_encode($transport['image']); ?>
                            <img src="data:image/jpeg;base64,<?php echo $imageData; ?>" alt="Transport Image" class="img-fluid" />
                        </div>
                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <p class="form-control"><?php echo htmlspecialchars($transport['type']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label for="modele" class="form-label">Modèle</label>
                        <p class="form-control"><?php echo htmlspecialchars($transport['modele']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label for="anneeFabrication" class="form-label">Année de Fabrication</label>
                        <p class="form-control"><?php echo htmlspecialchars($transport['anneeFabrication']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label for="marque" class="form-label">Marque</label>
                        <p class="form-control"><?php echo htmlspecialchars($transport['marque']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label for="poids" class="form-label">Poids (kg)</label>
                        <p class="form-control"><?php echo htmlspecialchars($transport['poids']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label for="volume" class="form-label">Volume (m³)</label>
                        <p class="form-control"><?php echo htmlspecialchars($transport['volume']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label for="longueur" class="form-label">Longueur (cm)</label>
                        <p class="form-control"><?php echo htmlspecialchars($transport['longueur']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label for="largeur" class="form-label">Largeur (cm)</label>
                        <p class="form-control"><?php echo htmlspecialchars($transport['largeur']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label for="hauteur" class="form-label">Hauteur (cm)</label>
                        <p class="form-control"><?php echo htmlspecialchars($transport['hauteur']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label for="dangereuses" class="form-label">Dangereuses</label>
                        <p class="form-control"><?php echo htmlspecialchars($transport['dangereuses']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label for="assurance" class="form-label">Assurance</label>
                        <p class="form-control"><?php echo htmlspecialchars($transport['assurance']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label for="driverName" class="form-label">Nom du conducteur </label>
                        <p class="form-control"><?php echo htmlspecialchars($transport['driverName']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label for="numeroPermis" class="form-label">Numéro du Permis</label>
                        <p class="form-control"><?php echo htmlspecialchars($transport['numeroPermis']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label for="experience" class="form-label">Éxperience</label>
                        <p class="form-control"><?php echo htmlspecialchars($transport['experience']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label for="qualifications" class="form-label">Qualifications</label>
                        <p class="form-control"><?php echo htmlspecialchars($transport['qualifications']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label for="dossierSecurite" class="form-label">Dossier de Sécurite</label>
                        <p class="form-control"><?php echo htmlspecialchars($transport['dossierSecurite']); ?></p>
                    </div>

                    <h6 class="mb-4">Information sur la société</h6>
                    <div class="mb-3">
                        <label for="societeNom" class="form-label">Nom de la société </label>
                        <p class="form-control"><?php echo htmlspecialchars($transport['societeNom']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label for="NumeroLicence" class="form-label">Numéro de la Licence</label>
                        <p class="form-control"><?php echo htmlspecialchars($transport['NumeroLicence']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse</label>
                        <p class="form-control"><?php echo htmlspecialchars($transport['adresse']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label for="numeroTelephone" class="form-label">Numéro de Téléphone</label>
                        <p class="form-control"><?php echo htmlspecialchars($transport['numeroTelephone']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <p class="form-control"><?php echo htmlspecialchars($transport['email']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label for="siteWeb" class="form-label">Site Web</label>
                        <p class="form-control"><?php echo htmlspecialchars($transport['siteWeb']); ?></p>
                    </div>
                    <div class="mb-3">
                        <label for="societeAssurance" class="form-label">Société Assurance</label>
                        <p class="form-control"><?php echo htmlspecialchars($transport['societeAssurance']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('../include/footer.php'); ?>
