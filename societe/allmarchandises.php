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

// Fetch all marchandises
$marchandisesQuery = "SELECT * FROM marchandises WHERE state=1";
if (isset($_GET['typeDeMoyen']) && $_GET['typeDeMoyen'] !== '') {
    $typeDeMoyen = $_GET['typeDeMoyen'];
    $marchandisesQuery .= " AND typeDeMoyen = '$typeDeMoyen'";
}
$marchandisesResult = mysqli_query($conn, $marchandisesQuery);
?>

<?php include_once('../include/header.php'); ?>

<div class="content">
    <div class="container-fluid pt-4 px-4">
        <div class="row">
            <div class="col-md-12 mb-4 text-center">
                <select id="typeDeMoyenFilter" class="form-select w-auto d-inline-block">
                    <option value="">Sélectioner le moyen de transport </option>
                    <option value="">Tous les Types</option>
                    <option value="Camions lourds">Camions lourds</option>
                    <option value="Citernes">Citernes</option>
                    <option value="transport lourd">Transport lourd</option>
                    <option value="Remorques spécialisées">Remorques spécialisées</option>
                </select>
                <button class="btn btn-primary" id="filterBtn">Filtrer</button>
            </div>
        </div>
        <div class="row">
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
                                <div class="btn-group" role="group">
                                    <a href="editMarchandises.php?id=<?php echo $marchandise['id']; ?>" class="btn btn-primary">Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>Aucun résultat trouvé</p>";
            }
            ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtn = document.getElementById('filterBtn');
        const typeDeMoyenFilter = document.getElementById('typeDeMoyenFilter');

        filterBtn.addEventListener('click', function() {
            const selectedTypeDeMoyen = typeDeMoyenFilter.value;
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('typeDeMoyen', selectedTypeDeMoyen);
            window.location.href = '?' + urlParams.toString();
        });
    });
</script>

<?php include_once('../include/footer.php'); ?>
