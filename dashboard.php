<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include 'db_connect.php';
$username = $_SESSION['username'];

// Verificar si el usuario ya tiene eventos
$sql = "SELECT * FROM eventos";
$result = $conn->query($sql);
$userEvents = "";
$eventOptions = "";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userEvents .= "<p>{$row['nombre']} - {$row['fecha']} (creado por {$row['creador']}) <form action='delete_event.php' method='post'><input type='hidden' name='eventID' value='{$row['id']}'><button type='submit' class='btn btn-danger'>Eliminar</button></form></p>";
        $eventOptions .= "<option value='{$row['id']}'" . (isset($_POST['eventID']) && $_POST['eventID'] == $row['id'] ? " selected" : "") . ">{$row['nombre']}</option>";
    }
} else {
    $userEvents = "<p>No tienes eventos próximos.</p>";
}

// Verificar si el usuario ya tiene una lista de regalos para un evento específico
$eventID = isset($_POST['eventID']) ? $_POST['eventID'] : null;
$userGifts = "";
if ($eventID) {
    $sql = "SELECT regalos FROM listas_regalos WHERE usuario='$username' AND evento_id='$eventID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userGifts = $row['regalos'];
    }
}

// Obtener la pareja del usuario
$pairedGifts = "";
$sql = "SELECT paired_user FROM user_pairs WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $pairedUser = $row['paired_user'];
    $sql = "SELECT regalos FROM listas_regalos WHERE usuario='$pairedUser' AND evento_id='$eventID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $pairedGifts = "<h2>Lista de Regalos de tu Pareja ($pairedUser)</h2>";
        $pairedGifts .= "<p>" . nl2br(htmlspecialchars($row['regalos'])) . "</p>";
    } else {
        $pairedGifts = "<p>Tu pareja ($pairedUser) no ha subido una lista de regalos para este evento.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizador de Intercambio de Regalos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="my-4">Bienvenido, <?php echo htmlspecialchars($username); ?>!</h1>
        
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" class="mb-4">
            <div class="form-group">
                <label for="eventID">Seleccionar Evento:</label>
                <select id="eventID" name="eventID" class="form-control" onchange="this.form.submit()">
                    <?php echo $eventOptions; ?>
                </select>
            </div>
        </form>

        <?php if ($eventID && $userGifts): ?>
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2>Tu Lista de Regalos para el Evento (ID: <?php echo $eventID; ?>)</h2>
                    <p><?php echo nl2br(htmlspecialchars($userGifts)); ?></p>
                </div>
            </div>
        <?php elseif ($eventID): ?>
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h2>Subir Lista de Regalos para el Evento (ID: <?php echo $eventID; ?>)</h2>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($eventID): ?>
            <form action="submit_gifts.php" method="post" class="mb-4">
                <input type="hidden" name="eventID" value="<?php echo $eventID; ?>">
                <div class="form-group">
                    <label for="gifts">Lista de Regalos:</label>
                    <textarea id="gifts" name="gifts" rows="4" class="form-control" required><?php echo htmlspecialchars($userGifts); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary"><?php echo $userGifts ? "Actualizar Lista de Regalos" : "Enviar Lista de Regalos"; ?></button>
            </form>
        <?php endif; ?>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h2>Tus Eventos</h2>
                <?php echo $userEvents; ?>
            </div>
        </div>
        
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h2>Crear Evento</h2>
                <form action="create_event.php" method="post">
                    <div class="form-group">
                        <label for="eventName">Nombre del Evento:</label>
                        <input type="text" id="eventName" name="eventName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="eventDate">Fecha del Evento:</label>
                        <input type="date" id="eventDate" name="eventDate" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Crear Evento</button>
                </form>
            </div>
        </div>
        
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h2>Emparejar con un Invitado Aleatorio</h2>
                <form action="match_random.php" method="post">
                    <button type="submit" class="btn btn-danger">Emparejar</button>
                </form>
            </div>
        </div>

        <?php if ($pairedGifts): ?>
            <h2>Tu Pareja de Intercambio</h2>
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <?php echo $pairedGifts; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Nueva sección para invitar usuarios por correo -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h2>Invitar Usuarios a un Evento</h2>
                <form action="invite_user.php" method="post">
                    <div class="form-group">
                        <label for="inviteEmail">Correo Electrónico del Usuario:</label>
                        <input type="email" id="inviteEmail" name="inviteEmail" class="form-control" required>
                    </div>
                    <input type="hidden" name="eventID" value="<?php echo $eventID; ?>">
                    <button type="submit" class="btn btn-primary">Invitar Usuario</button>
                </form>
            </div>
        </div>
        
        <form action="logout.php" method="post" class="mb-4">
            <button type="submit" class="btn btn-secondary">Cerrar Sesión</button>
        </form>
    </div>
</body>
</html>
