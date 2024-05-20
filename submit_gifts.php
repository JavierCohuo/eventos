<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $gifts = $_POST['gifts'];

    // Verificar si el usuario ya tiene una lista de regalos
    $sql = "SELECT id FROM listas_regalos WHERE usuario='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Actualizar la lista de regalos existente
        $sql = "UPDATE listas_regalos SET regalos='$gifts' WHERE usuario='$username'";
    } else {
        // Insertar una nueva lista de regalos
        $sql = "INSERT INTO listas_regalos (usuario, regalos) VALUES ('$username', '$gifts')";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Lista de regalos guardada correctamente.";
    } else {
        echo "Error al guardar la lista de regalos: " . $conn->error;
    }

    $conn->close();
    header("Location: dashboard.php");
    exit();
}
?>
