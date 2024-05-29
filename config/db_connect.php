<?php
$conn = mysqli_connect('localhost', "root", "", 'db');
if (!$conn) {
    echo 'Connection Erreur: ' . mysqli_connect_error();
}
?>