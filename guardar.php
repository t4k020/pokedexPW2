<?php
include_once "includes/conexion.php";

$id = intval($_POST["id"] ?? 0);
$nombre = $_POST["nombre"];
$numero = $_POST["numero"];
$nombreArchivo = $_POST["imagen_actual"];

if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
    if ($id != 0) {

        $rutaAnterior = "Assets/" . $nombreArchivo;

        if (!empty($nombreArchivo) && file_exists($rutaAnterior)) {
            unlink($rutaAnterior);
        }
    }

    $nombreArchivo = $_FILES["imagen"]["name"];
    $rutaArchivo = "Assets/" . $nombreArchivo;

    move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaArchivo);
}

$tipos = $_POST["tipos"];
$tipo1 = $tipos[0] ?? null;
$tipo2 = $tipos[1] ?? null;

$habilidades = $_POST["habilidades"];
$habilidad1 = $habilidades[0] ?? null;
$habilidad2 = $habilidades[1] ?? null;
$habilidad3 = $habilidades[2] ?? null;

$descripcion = $_POST["descripcion"];

if($id == 0) {
    $sql = "INSERT INTO pokemon (idNoIncremental, dirImagen, nombre, tipo1, tipo2, habilidad1, habilidad2, habilidad3, descripcion) 
VALUES ($numero, '$nombreArchivo', '$nombre', '$tipo1', '$tipo2','$habilidad1','$habilidad2','$habilidad3', '$descripcion')";
    $conn->query($sql);
    $id = $conn->insert_id;
}
else {
    $sql = "UPDATE pokemon
    SET idNoIncremental = $numero,
        nombre = '$nombre',
        dirImagen = '$nombreArchivo',
        tipo1 = '$tipo1',
        tipo2 = '$tipo2',
        habilidad1 = '$habilidad1',
        habilidad2 = '$habilidad2',
        habilidad3 = '$habilidad3',
        descripcion = '$descripcion'
        WHERE id = $id;";
    $conn->query($sql);
}

header("Location: detalle.php?id=" . $id);
echo $id;
$conn->close();

?>
