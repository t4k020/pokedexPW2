<?php
include_once "includes/conexion.php";
session_start();

/** @var mysqli $conn */

$busqueda = $conn->real_escape_string($_GET['termino'] ?? '');
//Traigo por metodo Get la busqueda del cliente.
// El el operador null coalescing (??) para evitar errores si está vacío.
//real_escape_string: evita que los datos enviados por usuarios rompan la consulta o causen inyecciones SQL.

$sql = "SELECT * FROM pokemon WHERE nombre LIKE '%$busqueda%'";
$result = $conn->query($sql);

//Lógica para cuando no se encuentran resultados y tengo que devolver el mensaje de error + todos los pokemones
if ($result->num_rows == 0) {
    $mensajeError = "Pokemon no encontrado";
    $sqlTodos = "SELECT * FROM pokemon ORDER BY idNoIncremental ASC";
    $result = $conn->query($sqlTodos);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de Búsqueda</title>
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
    <input type="text" name="termino" placeholder="Buscar pokemon">
    <button type="submit">Buscar</button>
</form>


<?php
if (isset($mensajeError)) {
    echo "<div class='alert alert-danger'>";
    echo "<p> $mensajeError</p>";
    echo "<p>Mostrando todos los Pokemon disponibles:</p>";
    echo "</div>";
}
?>

<div class="pokemon-grid">
    <?php
    //si hubo error, $result se sobreescribe y va a traer a todos los pokemones, sino va a traer a los que coincidan con la busqueda
    while ($row = $result->fetch_assoc()):
        // Procesamos los datos de la fila actual
        $ruta_imagen = "assets/" . $row['dirImagen'];
        $tipos = array_filter([$row['tipo1'], $row['tipo2']]);
        $habilidades = array_filter([$row['habilidad1'], $row['habilidad2'], $row['habilidad3']]);
        ?>


    <div class="card">
        <?php if (isset($_SESSION['nombre']) && $_SESSION['nombre'] === 'admin'): ?>
            <div class="card-actions">
                <a href="editar_formulario.php?id=<?php echo $row['id']; ?>" class="btn-action edit">✎</a>
                <a href="borrar.php?id=<?php echo $row['id']; ?>&img=<?php echo urlencode($row['dirImagen']); ?>"
                   class="btn-action delete" onclick="return confirm('¿Borrar?')">×</a>
            </div>
        <?php endif; ?>

        <a href="detalle.php?id=<?php echo $row['id']; ?>">
            <img src="<?php echo $ruta_imagen; ?>" alt="<?php echo $row['nombre']; ?>">
        </a>

        <p style="color: #888; margin: 0;">#<?php echo $row['idNoIncremental'] ?? ''; ?></p>
        <h2 style="text-transform: capitalize; margin: 10px 0;"><?php echo $row['nombre'] ?? ''; ?></h2>

        <div>
            <?php foreach ($tipos as $t): ?>
                <span class="tipo"><?php echo $t; ?></span>
            <?php endforeach; ?>
        </div>

        <div class="habilidades">
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
    ?>


</div>
</body>
</html>