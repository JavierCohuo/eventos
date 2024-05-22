<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include 'db_connect.php';

$eventName = $conn->real_escape_string($_POST['eventName']);
$eventDate = $conn->real_escape_string($_POST['eventDate']);
$eventCreator = $_SESSION['username'];

$sql = "INSERT INTO eventos (nombre, fecha, creador) VALUES ('$eventName', '$eventDate', '$eventCreator')";

if ($conn->query($sql) === TRUE) {
    header("Location: dashboard.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
