<?php
// 1. Conexión a la base de datos
include_once "includes/conexion.php";
// 2. Obtener el ID de la URL (usando el 'id' incremental de la base de datos)
$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// 3. Consultar los datos del Pokémon en la DB local
$sql = "SELECT * FROM pokemon WHERE id = $id";
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
        <style>
            body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }

            .detalle-container {
                max-width: 900px;
                margin: 50px auto;
                background: white;
                border-radius: 20px;
                display: flex;
                padding: 40px;
                box-shadow: 0 15px 35px rgba(0,0,0,0.1);
                gap: 50px;
                border-top: 15px solid #e67e22;
            }

            .img-container { flex: 1; text-align: center; background: #f9f9f9; border-radius: 15px; padding: 20px; }
            .img-container img { width: 100%; max-width: 350px; filter: drop-shadow(0 10px 10px rgba(0,0,0,0.1)); }
            .pokedex-number { font-size: 2rem; color: #ccc; font-weight: bold; margin-top: 10px; }

            .info-container { flex: 1.5; }
            h1 { font-size: 3rem; margin: 0; color: #333; text-transform: capitalize; }

            .tipo-badge {
                display: inline-block;
                padding: 8px 20px;
                border-radius: 50px;
                background: #78c850;
                color: white;
                font-weight: bold;
                margin-right: 10px;
                margin-top: 10px;
                text-transform: uppercase;
                font-size: 0.9rem;
            }

            .desc-box {
                background: #fff8f0;
                border-left: 5px solid #e67e22;
                padding: 20px;
                margin: 30px 0;
                font-style: italic;
                font-size: 1.1rem;
                color: #444;
                line-height: 1.6;
            }

            .skills-grid {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 15px;
            }

            .skill-item {
                background: #eee;
                padding: 12px;
                border-radius: 10px;
                text-align: center;
                font-weight: 500;
                color: #555;
                text-transform: capitalize;
            }

            .btn-volver {
                display: inline-block;
                margin-top: 40px;
                color: #e67e22;
                text-decoration: none;
                font-weight: bold;
                font-size: 1.1rem;
                transition: 0.2s;
            }
            .btn-volver:hover { transform: translateX(-5px); }
        </style>
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

            <a href="index.php" class="btn-volver">← Volver a la aldea</a>
        </div>
    </div>

    </body>
    </html>
<?php $conn->close(); ?>