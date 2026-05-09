<?php
// 1. Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "pokedex");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

?>

<?php

$nombre = $_POST["nombre"];
$numero = $_POST["numero"];

if(isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
    $nombreArchivo = $_FILES["imagen"]["name"];
    $tipoArchivo = $_FILES["imagen"]["type"];
    $rutaArchivo = "./Assets/" . $nombreArchivo;

    move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaArchivo);
}

$tipos = $_POST["tipos"];
$tipo1 = $tipos[0] ?? null;
$tipo2 = $tipos[1] ?? null;

$descripcion = $_POST["descripcion"];

$sql = "INSERT INTO pokemon (idNoIncremental, dirImagen, nombre, tipo1, tipo2, descripcion) 
VALUES ($numero, '$nombreArchivo', '$nombre', '$tipo1', '$tipo2', '$descripcion')";

$conn->query($sql);
$conn->close();

echo "<div>$nombre</div>";
echo "<img src='" . $rutaArchivo . "' />";
?>
