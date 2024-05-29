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

// Fetch orders data from the database
$query = "
SELECT 
    transport.category, 
    transport.type, 
    transport.poids, 
    transport.volume, 
    marchandises.placeChargement, 
    marchandises.placeDechargement, 
    marchandises.dateChargement, 
    societe.Nom, 
    societe.numeroTelephone
FROM 
    orders
INNER JOIN transport ON orders.idTransport = transport.id
INNER JOIN marchandises ON orders.idMarchandises = marchandises.id
INNER JOIN societe ON transport.idSociete = societe.id
";
$result = mysqli_query($conn, $query);
?>

<?php include_once('../include/header.php'); ?>

<div class="content">
    <!-- Display Orders Start -->
    <div class="container-fluid pt-4 px-4">
        <div class="row">
            <?php while ($order = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($order['category']); ?></h5>
                            <p class="card-text">
                                <strong>Type:</strong> <?php echo htmlspecialchars($order['type']); ?><br>
                                <strong>Poids:</strong> <?php echo htmlspecialchars($order['poids']); ?> kg<br>
                                <strong>Volume:</strong> <?php echo htmlspecialchars($order['volume']); ?> m³<br>
                                <strong>Place de Chargement:</strong> <?php echo htmlspecialchars($order['placeChargement']); ?><br>
                                <strong>Place de Déchargement:</strong> <?php echo htmlspecialchars($order['placeDechargement']); ?><br>
                                <strong>Date du Chargement:</strong> <?php echo htmlspecialchars($order['dateChargement']); ?><br>
                                <strong>Nom de la Société:</strong> <?php echo htmlspecialchars($order['Nom']); ?><br>
                                <strong>Numéro du Téléphone:</strong> <?php echo htmlspecialchars($order['numeroTelephone']); ?><br>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <!-- Display Orders End -->
</div>

<?php include_once('../include/footer.php'); ?>
