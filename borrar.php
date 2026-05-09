<?php
include_once "includes/conexion.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$sql = "DELETE FROM pokemon WHERE id = $id";
$result = $conn->query($sql);

header("Location: index.php");
$conn->close();

?>