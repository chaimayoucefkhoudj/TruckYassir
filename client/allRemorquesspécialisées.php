<?php
include_once('../config/db_connect.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['LogedIn'])) {
    header("Location: ../signin.php");
    exit();
} elseif ($_SESSION['privilege'] !== 'client') {
    header("Location: ../signin.php");
    exit();
}

// Handle state change
if (isset($_GET['change_state'])) {
    $id = $_GET['change_state'];
    $newState = $_GET['state'];

    $updateQuery = "UPDATE transport SET state = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, "ii", $newState, $id);
    mysqli_stmt_execute($stmt);
}
?>

<?php include_once('../include/header.php'); ?>

<div class="content">
    <div class="container-fluid pt-4 px-4">
        <div class="row">
            <div class="col-md-12 mb-4 text-center">
                <select id="typeFilter" class="form-select w-auto d-inline-block">
                    <option value="">Sélectioner type</option>
                    <option value="">Tous les types</option>
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
                <button class="btn btn-primary" id="filterBtn">Filtrer</button>
            </div>
        </div>
        <div class="row" id="transportContainer">
        <?php
                $transportQuery = "SELECT * FROM transport WHERE category = 'Remorques spécialisées' AND state=1";
                $transportResult = mysqli_query($conn, $transportQuery);

                if ($transportResult) {
                    if (mysqli_num_rows($transportResult) > 0) {
                        while ($row = mysqli_fetch_assoc($transportResult)) {
                            $imageData = base64_encode($row['image']);
                ?>
                            <div class="col-md-3 mb-4 card-wrapper" data-type="<?php echo htmlspecialchars($row['type']); ?>">
                                <div class="card h-100">
                                    <img src="data:image/jpeg;base64,<?php echo $imageData; ?>" class="card-img-top img-fluid w-100" alt="Transport Image">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($row['category']); ?></h5>
                                        <p>Type: <?php echo htmlspecialchars($row['type']); ?></p>
                                        <p>Modèle: <?php echo htmlspecialchars($row['modele']); ?></p>
                                        <p>Année: <?php echo htmlspecialchars($row['anneeFabrication']); ?></p>
                                        <p>Marque: <?php echo htmlspecialchars($row['marque']); ?></p>
                                        <p>Poids: <?php echo htmlspecialchars($row['poids']); ?> kg</p>
                                        <p>Volume: <?php echo htmlspecialchars($row['volume']); ?> m³</p>
                                        <p>État: 
                                            <span class="badge <?php echo $row['state'] == 1 ? 'bg-success' : 'bg-danger'; ?>">
                                                <?php echo $row['state'] == 1 ? 'Actvée' : 'Désactivée'; ?>
                                            </span>
                                        </p>
                                        <a href="detailse.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-primary">Voir</a>
                                    </div>
                                </div>
                            </div>
                <?php
                        }
                    } else {
                        echo "<p>Aucun enregistrement de transport trouvé</p>";
                    }
                } else {
                    echo "<p>Error fetching transport data: " . mysqli_error($conn) . "</p>";
                }
                ?>
        </div>
    </div>
</div>

<style>
    .card-wrapper {
        display: block;
    }

    .card-wrapper.inactive {
        display: none;
    }

    .fixed-img {
        height: 200px; /* Set the fixed height */
        width: 100%;  /* Ensure the image fills the card width */
        object-fit: cover; /* Ensure the image covers the area without distortion */
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtn = document.getElementById('filterBtn');
        const typeFilter = document.getElementById('typeFilter');
        const cardWrappers = document.querySelectorAll('.card-wrapper');

        filterBtn.addEventListener('click', function() {
            const selectedType = typeFilter.value;
            cardWrappers.forEach(card => {
                if (selectedType === '' || card.dataset.type === selectedType) {
                    card.classList.remove('inactive');
                } else {
                    card.classList.add('inactive');
                }
            });
        });
    });
</script>

<?php include_once('../include/footer.php'); ?>