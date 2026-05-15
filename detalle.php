<?php
require_once "clases/Pokemon.php";
// 1. Conexión a la base de datos
include_once "includes/conexion.php";
// 2. Obtener el ID de la URL (usando el 'id' incremental de la base de datos)
$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// 3. Consultar los datos del Pokémon en la DB local
$sql = "SELECT * FROM pokemon WHERE id = $id";
/** @var mysqli $conn */
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $fila = $result->fetch_assoc();

    // CREAMOS EL OBJETO (Él hace todo el mapeo solo)
    $p = new Pokemon($fila);
    $descripcion = isset($fila['descripcion']) ? $fila['descripcion'] : "Sin descripción disponible.";
} else {
    die("¡Pokémon no encontrado en la DB!");
}
?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Detalle de <?php echo $p->nombre; ?></title>
        <link rel="stylesheet" href="styleDetalle.css">
    </head>
    <body>

    <div class="detalle-container">
        <div class="img-container">
            <!-- Usamos las propiedades del objeto -->
            <img src="<?php echo $p->dirImagen; ?>" alt="<?php echo $p->nombre; ?>">
            <div class="pokedex-number">#<?php echo $p->idNoIncremental; ?></div>
        </div>

        <div class="info-container">
            <h1 style="text-transform: capitalize;"><?php echo $p->nombre; ?></h1>

            <div class="types">
                <!-- Usamos el método que creamos para los tipos -->
                <?php $p->imprimirTipos(); ?>
            </div>

            <div class="desc-box">
                "<?php echo $descripcion; ?>"
            </div>

            <h3>Habilidades de combate</h3>
            <div class="skills-grid">
                <!-- El objeto ya tiene las habilidades filtradas -->
                <?php foreach ($p->habilidades as $h): ?>
                    <div class="skill-item" style="text-transform: capitalize;">
                        <?php echo $h; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <a href="index.php" class="btn-volver">← Volver</a>
        </div>
    </div>

    </body>
</html>
<?php $conn->close(); ?>