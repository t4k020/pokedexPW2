<?php
// 1. Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "pokedex");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM tipo");

?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>Crear Nuevo Pokemon</title>
</head>
<body>
<form action="crear.php" method="POST" class="w3-container w3-padding-24" enctype="multipart/form-data">
    <h1>Crear Nuevo Pokemon</h1>

    <label>Nombre</label>
    <input class="w3-input w3-border" type="text" name="nombre" placeholder="Nombre del Pokemon" required>

    <label>Numero</label>
    <input class="w3-input w3-border" type="text" name="numero" placeholder="Numero" required>

    <label>Imagen</label>
    <input class="w3-input w3-border" type="file" name="imagen" placeholder="Imagen" required>


    <style>

        input[type="checkbox"]{
            display:none;
        }

        label img{
            width:50px;
            border:3px solid transparent;
            border-radius:50px;
            cursor:pointer;
            transition:0.2s;
        }

        /* Cuando está seleccionado */
        input[type="checkbox"]:checked + label img{
            border-color:black;
            transform:scale(1.05);
        }

    </style>
<div>
    <?php
    if ($result->num_rows > 0) :
        while($row = $result->fetch_assoc()) :
            $id_tipo = $row["idTipo"];
            $nombre_tipo = $row["nombre"];
            $ruta_imagen ="Assets/Tipo/" . $row["dirImagen"];
            $color = $row["color"];
    ?>

    <input type="checkbox" id="<?php echo $nombre_tipo; ?>" name="tipos[]" value="<?php echo $nombre_tipo; ?>">

    <label for="<?php echo $nombre_tipo; ?>">
        <img
                src="<?php echo $ruta_imagen; ?>"
                alt="<?php echo $nombre_tipo; ?>"
                title="<?php echo $nombre_tipo; ?>"
                style="background-color: <?php echo $color; ?>"
        >
    </label>

    <?php
    endwhile;
    endif;
    ?>
</div>

    <label>Descripción</label>
    <input class="w3-input w3-border" type="text" name="descripcion" placeholder="Descripcion de Pokemon">

    <div class="w3-padding-24">
        <button type="submit" class="w3-button w3-deep-purple w3-block w3-round">
            <b>GUARDAR DATOS</b>
        </button>
    </div>
</form>
<!--    Datos extras??-->

<?php $conn->close(); ?>
</body>
</html>
