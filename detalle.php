<?php
// 1. Obtener el ID de la URL
$id = isset($_GET['id']) ? $_GET['id'] : 1;

// 2. Obtener datos básicos del Pokémon (Estadísticas, altura, peso)
$data = json_decode(file_get_contents("https://pokeapi.co/api/v2/pokemon/$id"), true);

// 3. Obtener la descripción y datos curiosos (Species)
$species = json_decode(file_get_contents($data['species']['url']), true);

// Buscamos la descripción en español
$descripcion = "";
foreach ($species['flavor_text_entries'] as $entry) {
    if ($entry['language']['name'] == 'es') {
        $descripcion = $entry['flavor_text'];
        break; // Nos quedamos con la primera que encontremos
    }
}

// Datos Curiosos
$categoria = "";
foreach ($species['genera'] as $gen) {
    if ($gen['language']['name'] == 'es') {
        $categoria = $gen['genus'];
        break;
    }
}

$nombre = ucfirst($data['name']);
$imagen = $data['sprites']['other']['official-artwork']['front_default'];
$altura = $data['height'] / 10; // Convertir a metros
$peso = $data['weight'] / 10;   // Convertir a kilos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de <?php echo $nombre; ?></title>
    <link rel="stylesheet" href="estilos.css"> <!-- Reutiliza tus estilos -->
    <style>
        .detalle-container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            border-radius: 20px;
            display: flex;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            gap: 40px;
        }
        .img-container { flex: 1; text-align: center; }
        .img-container img { width: 100%; max-width: 300px; }

        .info-container { flex: 1; }
        .stats-bar {
            background: #eee;
            border-radius: 10px;
            margin: 10px 0;
            overflow: hidden;
        }
        .fill {
            height: 10px;
            background: #e67e22;
        }
        .badge {
            background: #f1f1f1;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            margin-right: 5px;
        }
        .desc { font-style: italic; color: #555; margin: 20px 0; }
    </style>
</head>
<body>

<div class="detalle-container">
    <div class="img-container">
        <img src="<?php echo $imagen; ?>" alt="<?php echo $nombre; ?>">
        <h2>#<?php echo $id; ?></h2>
    </div>

    <div class="info-container">
        <h1><?php echo $nombre; ?></h1>
        <p><strong>Categoría:</strong> <?php echo $categoria; ?></p>

        <div class="desc">
            "<?php echo $descripcion; ?>"
        </div>

        <div class="badges">
            <span class="badge">Altura: <?php echo $altura; ?> m</span>
            <span class="badge">Peso: <?php echo $peso; ?> kg</span>
        </div>

        <h3>Estadísticas de combate</h3>
        <?php foreach ($data['stats'] as $s): ?>
            <div>
                <small><?php echo strtoupper($s['stat']['name']); ?>: <?php echo $s['base_stat']; ?></small>
                <div class="stats-bar">
                    <div class="fill" style="width: <?php echo ($s['base_stat'] > 100 ? 100 : $s['base_stat']); ?>%"></div>
                </div>
            </div>
        <?php endforeach; ?>

        <br>
        <a href="index.php" style="color: #e67e22; text-decoration: none; font-weight: bold;">← Volver a la aldea</a>
    </div>
</div>

</body>
</html>
