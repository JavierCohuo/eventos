<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventID = $_POST['eventID'];
    $inviteEmail = $_POST['inviteEmail'];

    // Insertar la invitación en la base de datos
    $sql = "INSERT INTO invitaciones_eventos (evento_id, email_invitado) VALUES ('$eventID', '$inviteEmail')";
    if ($conn->query($sql) === TRUE) {
        // Enviar correo electrónico de invitación
        $to = $inviteEmail;
        $subject = "¡Has sido invitado a un evento!";
        $message = "¡Has sido invitado a un evento! Ingresa a la página para más detalles.";
        $headers = "From: tu@email.com"; // Cambia esto al correo electrónico desde el que deseas enviar las invitaciones
        mail($to, $subject, $message, $headers);
        echo "Invitación enviada correctamente.";
    } else {
        echo "Error al enviar la invitación: " . $conn->error;
    }

    $conn->close();
    header("Location: dashboard.php");
    exit();
} else {
    header("Location: dashboard.php");
    exit();
}
?>
