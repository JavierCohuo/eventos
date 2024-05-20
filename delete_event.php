<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventID = $_POST['eventID'];

    // Eliminar el evento de la base de datos
    $sql = "DELETE FROM eventos WHERE id='$eventID'";
    if ($conn->query($sql) === TRUE) {
        echo "Evento eliminado correctamente.";
    } else {
        echo "Error al eliminar el evento: " . $conn->error;
    }
}

$conn->close();
header("Location: dashboard.php");
exit();
?>
