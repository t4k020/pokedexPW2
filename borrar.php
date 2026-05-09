<?php
$conn = new mysqli("localhost", "root", "", "pokedex");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$sql = "DELETE FROM pokemon WHERE id = $id";
$result = $conn->query($sql);

header("Location: index.php");
$conn->close();

?>