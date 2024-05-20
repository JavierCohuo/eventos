<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include 'db_connect.php';
$username = $_SESSION['username'];

// Verificar si el usuario ya está emparejado
$sql = "SELECT paired_user FROM user_pairs WHERE username='$username'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    // Obtener usuarios no emparejados
    $sql = "SELECT name AS username FROM usuarios WHERE name NOT IN (SELECT paired_user FROM user_pairs) AND name != '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row['username'];
        }

        // Emparejar aleatoriamente
        $paired_user = $users[array_rand($users)];

        // Insertar el emparejamiento en la base de datos
        $stmt = $conn->prepare("INSERT INTO user_pairs (username, paired_user) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $paired_user);
        $stmt->execute();

        // También insertar el emparejamiento inverso para evitar duplicados
        $stmt = $conn->prepare("INSERT INTO user_pairs (username, paired_user) VALUES (?, ?)");
        $stmt->bind_param("ss", $paired_user, $username);
        $stmt->execute();

        $_SESSION['paired_user'] = $paired_user;
        header("Location: dashboard.php");
        exit();
    } else {
        echo "No hay usuarios disponibles para emparejar.";
    }
} else {
    $row = $result->fetch_assoc();
    $_SESSION['paired_user'] = $row['paired_user'];
    header("Location: dashboard.php");
    exit();
}
?>
