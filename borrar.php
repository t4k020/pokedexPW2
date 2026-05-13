<?php
include_once "includes/conexion.php";
/** @var mysqli $conn */ // Esto le avisa al IDE que la variable viene del include
session_start();

if (!isset($_SESSION['nombre']) || $_SESSION['nombre'] !== 'admin') {


    header("Location: index.php");


    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$imagen = isset($_GET["img"]) ? $_GET["img"] : "";

if ($id > 0) {
    // 1. Primero intentar borrar la imagen
    $rutaArchivo = $imagen; // Quitamos el "assets/" porque ya viene en la variable $imagen

    if (!empty($imagen) && file_exists($rutaArchivo)) {
        unlink($rutaArchivo);
    }
    // 2. Luego borrar de la base de datos
    $sql = "DELETE FROM pokemon WHERE id = $id";
    $conn->query($sql);
}

$conn->close();
header("Location: index.php");
exit;
