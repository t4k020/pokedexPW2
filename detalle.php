<?php
// 1. Conexión a la base de datos
include_once "includes/conexion.php";
// 2. Obtener el ID de la URL (usando el 'id' incremental de la base de datos)
$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// 3. Consultar los datos del Pokémon en la DB local
$sql = "SELECT * FROM pokemon WHERE id = $id";
/** @var mysqli $conn */
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $p = $result->fetch_assoc();

    // Mapear datos
    $nombre      = ucfirst($p['nombre']);
    $id_pokedex  = $p['idNoIncremental'];
    $imagen      = "assets/" . $p['dirImagen'];
    $descripcion = $p['descripcion'];

    // Agrupar tipos y habilidades (quitando los que sean NULL)
    $tipos       = array_filter([$p['tipo1'], $p['tipo2']]);
    $habilidades = array_filter([$p['habilidad1'], $p['habilidad2'], $p['habilidad3'], $p['habilidad4']]);
} else {
    die("¡Pokémon no encontrado en la DB!");
}
?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Detalle de <?php echo $nombre; ?></title>
        <link rel="stylesheet" href="styleDetalle.css">
    </head>
    <body>

    <div class="detalle-container">
        <div class="img-container">
            <img src="<?php echo $imagen; ?>" alt="<?php echo $nombre; ?>">
            <div class="pokedex-number">#<?php echo $id_pokedex; ?></div>
        </div>

        <div class="info-container">
            <h1><?php echo $nombre; ?></h1>

            <div class="types">
                <?php foreach ($tipos as $t): ?>
                    <span class="tipo-badge"><?php echo $t; ?></span>
                <?php endforeach; ?>
            </div>

            <div class="desc-box">
                "<?php echo $descripcion; ?>"
            </div>

            <h3>Habilidades de combate</h3>
            <div class="skills-grid">
                <?php foreach ($habilidades as $h): ?>
                    <div class="skill-item"><?php echo $h; ?></div>
                <?php endforeach; ?>
            </div>

            <a href="pokedex.php" class="btn-volver">← Volver</a>
        </div>
    </div>

    </body>
    </html>
<?php $conn->close(); ?>