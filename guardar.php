<?php
include_once "includes/conexion.php";
/** @var mysqli $conn */

$id = intval(isset($_POST["id"]) ? $_POST["id"] : 0);
$nombre = $_POST["nombre"];
$numero = $_POST["numero"];
$nombreArchivo = $_POST["imagen_actual"] ?? "";

if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
    if ($id != 0) {

        $rutaAnterior = "assets/" . $nombreArchivo;

        if (!empty($nombreArchivo) && file_exists($rutaAnterior)) {
            unlink($rutaAnterior);
        }
    }

    $nombreArchivo = $_FILES["imagen"]["name"];
    $rutaArchivo = "assets/" . $nombreArchivo;

    move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaArchivo);
}

$tipos = $_POST["tipos"];

$habilidades = $_POST["habilidades"];
$habilidad1 = isset($habilidades[0]) ? $habilidades[0] : null;
$habilidad2 = isset($habilidades[1]) ? $habilidades[1] : null;
$habilidad3 = isset($habilidades[2]) ? $habilidades[2] : null;

$descripcion = $_POST["descripcion"];

if($id == 0) {
    $sql = "INSERT INTO Pokemon (idNoIncremental, dirImagen, nombre, habilidad1, habilidad2, habilidad3, descripcion) 
VALUES ($numero, '$nombreArchivo', '$nombre','$habilidad1','$habilidad2','$habilidad3', '$descripcion')";
    $conn->query($sql);
    $id = $conn->insert_id;
}
else {
    $sql = "UPDATE Pokemon
    SET idNoIncremental = $numero,
        nombre = '$nombre',
        dirImagen = '$nombreArchivo',
        habilidad1 = '$habilidad1',
        habilidad2 = '$habilidad2',
        habilidad3 = '$habilidad3',
        descripcion = '$descripcion'
        WHERE id = $id";
    $conn->query($sql);
    $conn->query("DELETE FROM Pokemon_tipo WHERE pokemonId = $id");
}

foreach ($tipos as $tipo) {
    $resultado = $conn->query("SELECT idTipo FROM Tipo WHERE nombre = '$tipo'");

    if ($row = $resultado->fetch_assoc()) {
        $idTipo = $row["idTipo"];
        $conn->query("INSERT INTO Pokemon_tipo(pokemonId, tipoId) VALUES ($id, $idTipo)");
    }
}

$conn->close();
header("Location: detalle.php?id=" . $id);
exit();
?>
