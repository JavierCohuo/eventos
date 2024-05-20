<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventName = $_POST['eventName'];
    $eventDate = $_POST['eventDate'];
    $eventCreator = $_SESSION['username'];

    // Insertar el nuevo evento en la base de datos
    $sql = "INSERT INTO eventos (nombre, fecha, creador) VALUES ('$eventName', '$eventDate', '$eventCreator')";
    if ($conn->query($sql) === TRUE) {
        echo "Evento creado correctamente.";
        
        // Obtener el ID del evento recién creado
        $eventId = $conn->insert_id;
        
        // Insertar invitaciones a los usuarios
        if (isset($_POST['invitedUsers']) && is_array($_POST['invitedUsers'])) {
            foreach ($_POST['invitedUsers'] as $userEmail) {
                $sqlInvite = "INSERT INTO invitaciones_eventos (evento_id, email_invitado) VALUES ('$eventId', '$userEmail')";
                $conn->query($sqlInvite);
            }
        }
    } else {
        echo "Error al crear el evento: " . $conn->error;
    }

    $conn->close();
    header("Location: dashboard.php");
    exit();
} else {
    header("Location: dashboard.php");
    exit();
}
?>
