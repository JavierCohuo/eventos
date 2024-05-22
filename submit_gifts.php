<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include 'db_connect.php';
$username = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventID = $_POST['eventID'];
    $gifts = $_POST['gifts'];

    // Verificar si el usuario ya tiene una lista de regalos para el evento
    $sql = "SELECT * FROM listas_regalos WHERE usuario='$username' AND evento_id='$eventID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Actualizar la lista de regalos existente
        $sql = "UPDATE listas_regalos SET regalos='$gifts' WHERE usuario='$username' AND evento_id='$eventID'";
    } else {
        // Insertar una nueva lista de regalos
        $sql = "INSERT INTO listas_regalos (usuario, evento_id, regalos) VALUES ('$username', '$eventID', '$gifts')";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: main.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
