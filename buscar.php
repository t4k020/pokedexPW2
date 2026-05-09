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

if (isset($mensajeError)){
    echo "<div class='alert alert-danger'>";
        echo "<p> $mensajeError</p>";
        echo "<p>Mostrando todos los Pokémon disponibles:</p>";
    echo "</div>";
}
?>

<div class="pokedex-container">
    <?php
    //si hubo error, $result se sobreescribe y va a traer a todos los pokemones, sino va a traer a los que coincidan con la busqueda
    while ($pokemon = $result->fetch_assoc()) {
        echo "<div class='card'>";
        echo "<h3>" . $pokemon['nombre'] . "</h3>";

        // Lógica de tipos que armamos antes
        echo "<p>Tipos: " . $pokemon['tipo1'];
        if (!empty($pokemon['tipo2'])) {
            echo " / " . $pokemon['tipo2'];
        }
        echo "</p>";
        echo "</div>";
    }
    ?>
</div>