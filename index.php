<?php
session_start();
require_once "clases/Pokemon.php";
include_once "includes/conexion.php";
$conn = new mysqli("localhost", "root", "", "pokedex");

$sql = "SELECT P.*, GROUP_CONCAT(T.nombre) AS tipos
FROM pokemon P
LEFT JOIN Pokemon_tipo R ON P.id = R.pokemonId
LEFT JOIN Tipo T ON T.idTipo = R.tipoId
GROUP BY P.idNoIncremental
ORDER BY P.idNoIncremental ASC";
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

    <?php if (isset($_SESSION['nombre'])): ?>
        <!-- Esto se muestra solo si el usuario YA entró -->
        <div class="user-info">
            <span>Bienvenido, <strong><?php echo $_SESSION['nombre']; ?></strong></span>
            <a href="cerrarSesion.php" class="btn">Cerrar Sesión</a>
        </div>
    <?php else: ?>
        <!-- Esto se muestra solo si NO hay sesión -->
        <form action="validarAdmin.php" class="nav-form" method="POST">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="pass" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
        </form>
    <?php endif; ?>
</nav>

<form class="nav-search" action="buscar.php" method="GET">
    <input type="search" name="termino" placeholder="Buscar pokemon">
    <button type="submit">Buscar</button>
</form>

<?php if (isset($_SESSION['nombre']) && $_SESSION['nombre'] === 'admin'): ?>
    <a class="btn-random" href="crear_formulario.php">
        CREAR POKEMON
    </a>
<?php endif; ?>

<div class="pokemon-grid">
    <?php
    if ($result->num_rows > 0):
        while ($row = $result->fetch_assoc()):
            // CREAMOS EL OBJETO
            $p = new Pokemon($row);
            ?>

            <div class="card">

                <a href="detalle.php?id=<?php echo $p->id; ?>">
                    <img src="<?php echo $p->dirImagen; ?>" alt="<?php echo $p->nombre; ?>">
                </a>

                <p style="color: #888; margin: 0;">#<?php echo $p->idNoIncremental; ?></p>
                <h2 style="text-transform: capitalize; margin: 10px 0;"><?php echo $p->nombre; ?></h2>

                <div>
                    <?php $p->imprimirTipos(); // USAMOS EL MÉTODO DE LA CLASE
                    ?>
                </div>

                <div class="habilidades">
                    <strong>Habilidades:</strong>
                    <ul style="padding-left: 20px; margin: 5px 0;">
                        <?php foreach ($p->habilidades as $h): ?>
                            <li style="text-transform: capitalize;"><?php echo $h; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endwhile; endif; ?>
</div>


</body>
</html>
