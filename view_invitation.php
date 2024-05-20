<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include 'db_connect.php';
$username = $_SESSION['username'];

// Ver eventos a los que ha sido invitado
$sql = "SELECT eventos.nombre, eventos.fecha FROM eventos 
        JOIN invitaciones_eventos ON eventos.id = invitaciones_eventos.evento_id 
        WHERE invitaciones_eventos.email_invitado='$username'";
$result = $conn->query($sql);
$invitedEvents = "";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $invitedEvents .= "<p>{$row['nombre']} - {$row['fecha']}</p>";
    }
} else {
    $invitedEvents = "<p>No has sido invitado a ningún evento.</p>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos Invitados</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Eventos a los que has sido invitado, <?php echo htmlspecialchars($username); ?>!</h1>
        <?php echo $invitedEvents; ?>
        
        <form action="logout.php" method="post">
            <button type="submit">Cerrar Sesión</button>
        </form>
    </div>
</body>
</html>
