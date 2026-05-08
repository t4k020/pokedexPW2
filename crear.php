<?php
// 1. Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "pokedex");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<?php

$nombre = $_POST["nombre"];
$numero = $_POST["numero"];
$tipo = $_POST["tipo"];
$descripcion = $_POST["descripcion"];

if(isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
    $nombreArchivo = $_FILES["imagen"]["name"];
    $tipoArchivo = $_FILES["imagen"]["type"];
    $rutaArchivo = "./Assets/" . $nombreArchivo;

    move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaArchivo);
}

$sql = "INSERT INTO pokemon (idNoIncremental, dirImagen, nombre, tipo1, descripcion) 
VALUES ($numero, '$nombreArchivo', '$nombre', '$tipo', '$descripcion')";

$conn->query($sql);
$conn->close();

echo "<div>$nombre</div>";
echo "<img src='" . $rutaArchivo . "' />";
?>

</body>
</html>
