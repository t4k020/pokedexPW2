<?php
session_start();


$conn = new mysqli("localHost", "root", "", "pokedex");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$sql = "SELECT * FROM pokemon ORDER BY idNoIncremental ASC";
$result = $conn->query($sql);




?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Aleatorio</title>
    <link rel="stylesheet" href="stylePokedex.css">
</head>
<body>

<nav class="navbar">

    <div class="nav-logo">
        <img src="https://via.placeholder.com/40" alt="Logo">
        <span class="logo-name">Poke dex</span>
    </div>


    <div class="nav-title">
        <h1>Gestión de Aldea</h1>
    </div>


    <?php if (isset($_SESSION['nombre'])): ?>
        <!-- Esto se muestra solo si el usuario YA entró -->
        <div class="user-info">
            <span>Bienvenido, <strong><?php echo $_SESSION['nombre']; ?></strong></span>
            <a href="cerrarSesion.php" class="btn">Cerrar Sesión</a>
        </div>
    <?php else: ?>
        <!-- Esto se muestra solo si NO hay sesión (el formulario original) -->
        <form action="validarAdmin.php" class="nav-form" method="POST">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="pass" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
        </form>
    <?php endif; ?>
</nav>

<form class="nav-search" action="buscar.php" method="POST">
    <input type="search" name="q" placeholder="Buscar pokimon">
    <button type="submit">Buscar</button>
</form>

<?php if (isset($_SESSION['nombre']) && $_SESSION['nombre'] === 'admin'): ?>
    <button class="btn-random" onclick="">
        CREAR POKEMON
    </button>
<?php endif; ?>

<div class="pokemon-grid">
    <?php
    include_once "includes/conexion.php";
    $sql = "SELECT * FROM pokemon ORDER BY idNoIncremental ASC";

    /** @var mysqli $conn */
    $result = $conn->query($sql);
    // 3. El Bucle Mágico: Mientras haya filas en la DB, crea una carta
    if ($result->num_rows > 0):
        while($row = $result->fetch_assoc()):

            // Procesamos los datos de la fila actual
            $ruta_imagen = "assets/" . $row['dirImagen'];
            $tipos = array_filter([$row['tipo1'], $row['tipo2']]); // Crea array y quita nulos
            $habilidades = array_filter([$row['habilidad1'], $row['habilidad2'], $row['habilidad3'], $row['habilidad4']]);
            ?>

            <div class="card">
                <?php if (isset($_SESSION['nombre']) && $_SESSION['nombre'] === 'admin'): ?>
                    <div class="card-actions">
                        <a href="editar.php?id=<?php echo $row['id']; ?>" class="btn-action edit">✎</a>
                        <a href="borrar.php?id=<?php echo $row['id']; ?>" class="btn-action delete" onclick="return confirm('¿Borrar?')">×</a>
                    </div>
                <?php endif; ?>

                <a href="detalle.php?id=<?php echo $row['id']; ?>">
                    <img src="<?php echo $ruta_imagen; ?>" alt="<?php echo $row['nombre']; ?>">
                </a>

                <p style="color: #888; margin: 0;">#<?php echo $row['idNoIncremental']; ?></p>
                <h2 style="text-transform: capitalize; margin: 10px 0;"><?php echo $row['nombre']; ?></h2>

                <div>
                    <?php foreach ($tipos as $t): ?>
                        <span class="tipo"><?php echo $t; ?></span>
                    <?php endforeach; ?>
                </div>

                <div style="text-align: left; margin-top: 15px; font-size: 0.9rem;">
                    <strong>Habilidades:</strong>
                    <ul style="padding-left: 20px; margin: 5px 0;">
                        <?php foreach ($habilidades as $h): ?>
                            <li style="text-transform: capitalize;"><?php echo $h; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

        <?php
        endwhile;
    else:
        echo "<p>No hay Pokémon en la base de datos.</p>";
    endif;
    $conn->close();
    ?>
</div>



</body>
</html>
