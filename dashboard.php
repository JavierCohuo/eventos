<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include 'db_connect.php';
$username = $_SESSION['username'];

// Verificar si el usuario ya tiene una lista de regalos
$sql = "SELECT regalos FROM listas_regalos WHERE usuario='$username'";
$result = $conn->query($sql);
$userGifts = "";

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $userGifts = $row['regalos'];
}

// Verificar si el usuario ya tiene eventos
$sql = "SELECT * FROM eventos";
$result = $conn->query($sql);
$userEvents = "";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userEvents .= "<p>{$row['nombre']} - {$row['fecha']} <form action='delete_event.php' method='post'><input type='hidden' name='eventID' value='{$row['id']}'><button type='submit' class='btn btn-danger'>Eliminar</button></form></p>";
    }
} else {
    $userEvents = "<p>No tienes eventos próximos.</p>";
}

// Obtener la pareja del usuario
$pairedGifts = "";
$sql = "SELECT paired_user FROM user_pairs WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $pairedUser = $row['paired_user'];
    $sql = "SELECT regalos FROM listas_regalos WHERE usuario='$pairedUser'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $pairedGifts = "<h2>Lista de Regalos de tu Pareja ($pairedUser)</h2>";
        $pairedGifts .= "<p>" . nl2br(htmlspecialchars($row['regalos'])) . "</p>";
    } else {
        $pairedGifts = "<p>Tu pareja ($pairedUser) no ha subido una lista de regalos.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizador de Intercambio de Regalos</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            padding: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
        .card-header {
            background-color: red;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Tu Lista de Regalos</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($userGifts): ?>
                            <p><?php echo nl2br(htmlspecialchars($userGifts)); ?></p>
                            <h6>Editar Lista de Regalos</h6>
                        <?php else: ?>
                            <p>No tienes una lista de regalos.</p>
                            <h6>Subir Lista de Regalos</h6>
                        <?php endif; ?>
                        <form action="submit_gifts.php" method="post">
                            <div class="form-group">
                                <label for="gifts">Lista de Regalos:</label>
                                <textarea id="gifts" name="gifts" rows="4" class="form-control" required><?php echo htmlspecialchars($userGifts); ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary"><?php echo $userGifts ? "Actualizar Lista de Regalos" : "Enviar Lista de Regalos"; ?></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Tus Eventos</h5>
                    </div>
                    <div class="card-body">
                        <?php echo $userEvents; ?>
                        <h6>Crear Evento</h6>
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
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Emparejar con un Invitado Aleatorio</h5>
                    </div>
                    <div class="card-body">
                        <form action="match_random.php" method="post">
                            <button type="submit" class="btn btn-primary">Emparejar</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <?php if ($pairedGifts): ?>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Tu Pareja de Intercambio</h5>
                        </div>
                        <div class="card-body">
                            <?php echo $pairedGifts; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="card">
                    <div class="card-body">
                        <form action="logout.php" method="post">
                            <button type="submit" class="btn btn-danger">Cerrar Sesión</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
