<?php
include_once "includes/conexion.php";
/** @var mysqli $conn */

$id = intval($_POST["id"] ?? 0);

$volver = $_SERVER['HTTP_REFERER'] ?? 'index.php';
$separador = str_contains($volver, '?') ? '&' : '?';

$nombre = $_POST["nombre"];
$verificarNombre = $conn->query("SELECT id FROM Pokemon WHERE nombre = '$nombre' AND id != $id");
if ($verificarNombre->num_rows > 0) {
    $conn->close();
    header("Location: " . $volver . $separador . "error=nombre");
    exit();
}

$numero = $_POST["numero"];
$verificarNumero = $conn->query("SELECT id FROM Pokemon WHERE idNoIncremental = $numero AND id != $id");
if ($verificarNumero->num_rows > 0) {
    $conn->close();
    header("Location: " . $volver . $separador . "error=numero");
    exit();
}

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
$habilidad1 = $habilidades[0] ?? null;
$habilidad2 = $habilidades[1] ?? null;
$habilidad3 = $habilidades[2] ?? null;

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
