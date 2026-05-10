<?php
include_once "includes/conexion.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$imagen = $_GET["img"] ?? "";

if ($id != 0) {

    $rutaArchivo = "assets/" . $imagen;

    if (!empty($imagen) && file_exists($rutaArchivo)) {
        unlink($rutaArchivo);
    }
}
$result = $conn->query("DELETE FROM pokemon WHERE id = $id");

$conn->close();
header("Location: index.php");
exit;
?>