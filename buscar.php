<?php
include_once "includes/conexion.php";

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
    <!-- Lado Izquierdo: Imagen y Nombre del Logo -->
    <div class="nav-logo">
        <img src="https://via.placeholder.com/40" alt="Logo">
        <span class="logo-name">Poke dex</span>
    </div>

    <!-- Centro: Título -->
    <div class="nav-title">
        <h1>Gestión de Aldea</h1>
    </div>

    <!-- Lado Derecho: Formulario de Ingreso -->
    <form class="nav-form">
        <input type="text" placeholder="Usuario" required>
        <input type="password" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>
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
    while ($pokemon = $result->fetch_assoc()) {
        echo "<div class='card'>";
        echo "<a href='detalle.php?id=" . $pokemon['id'] . "'><img src='Assets/" . $pokemon['dirImagen'] . "' alt='" . $pokemon['nombre'] . "'></a>";        echo "<h3>" . $pokemon['nombre'] . "</h3>";

        echo "<p class='tipo'>" . $pokemon['tipo1'] . "</p>";
        if (!empty($pokemon['tipo2'])) {
            echo "<p class='tipo'>" . $pokemon['tipo2'] . "</p>";
        }
        echo "<div class='habilidades'>";
        echo "<strong>Habilidades:</strong>";
        echo "<ul>";
        echo "<li>" . $pokemon['habilidad1'] . "</li>";
        if (!empty($pokemon['habilidad2'])) {
            echo "<li>" . $pokemon['habilidad2'] . "</li>";
        }
        if (!empty($pokemon['habilidad3'])){
            echo "<li>" . $pokemon['habilidad3'] . "</li>";
        }
        echo "</ul>";
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>
</body>
</html>