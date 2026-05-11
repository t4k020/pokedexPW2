<?php
include_once "includes/conexion.php";

session_start();

if (!isset($_SESSION['nombre']) || $_SESSION['nombre'] !== 'admin') {


    header("Location: index.php");


    exit();
}

$result_tipos = $conn->query("SELECT * FROM tipo");

?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Crear Pokemon</title>

    <style>
        input[type="checkbox"]:checked + label img {
            transform: scale(1.15);
        }
    </style>

</head>
<body class="bg-light">
<div class="container py-5">
    <form action="guardar.php" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
        <h1 class="mb-4">Crear Nuevo Pokemon</h1>

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input class="form-control" type="text" name="nombre" placeholder="Nombre del Pokémon" required>
        </div>

        <div class="mb-3">
            <label class="form-label">#Número Identificador</label>
            <input class="form-control" type="text" name="numero" placeholder="Número"
                   pattern="\d+" min="1" required>
        </div>

        <div class="mb-4">
            <label class="form-label">Imagen</label>
            <input class="form-control" type="file" name="imagen" required>
        </div>

        <div class="mb-4">
            <label class="form-label d-block">Tipos
                <span id="error" class="text-danger ms-2"></span>
            </label>


            <div class="d-flex flex-wrap gap-3 justify-content-center">

                <?php
                if ($result_tipos->num_rows > 0) :
                    while ($row = $result_tipos->fetch_assoc()) :

                        $id_tipo = $row["idTipo"];
                        $nombre_tipo = $row["nombre"];
                        $ruta_imagen = "Assets/Tipo/" . $row["dirImagen"];
                        ?>

                        <div>
                            <input type="checkbox" class="btn-check" id="<?php echo $nombre_tipo; ?>"
                                   name="tipos[]" value="<?php echo $nombre_tipo; ?>">

                            <label class="btn btn-outline-dark rounded-circle p-1" for="<?php echo $nombre_tipo; ?>">
                                <img src="<?php echo $ruta_imagen; ?>" alt="<?php echo $nombre_tipo; ?>"
                                     title="<?php echo $nombre_tipo; ?>" width="40px"></label>
                        </div>

                    <?php
                    endwhile;
                endif;
                ?>

            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Habilidades</label>
            <input class="form-control" type="text" name="habilidades[]" placeholder="Habilidad 1">
            <input class="form-control" type="text" name="habilidades[]" placeholder="Habilidad 2">
            <input class="form-control" type="text" name="habilidades[]" placeholder="Habilidad Oculta">
        </div>

        <div class="mb-4">
            <label class="form-label">Descripción</label>
            <textarea class="form-control" name="descripcion" rows="3" placeholder="Descripción del Pokémon"></textarea>
        </div>
        <!--    Datos extras??-->

        <button type="submit" class="btn btn-primary w-100">
            <b>GUARDAR DATOS</b>
        </button>
    </form>

</div>


<?php $conn->close(); ?>
</body>
<script>
    const checks = document.querySelectorAll('input[name="tipos[]"]');

    checks.forEach(check => {

        check.addEventListener('change', () => {

            const seleccionados =
                document.querySelectorAll('input[name="tipos[]"]:checked');

            // Máximo 2
            if (seleccionados.length > 2) {
                check.checked = false;
                error.textContent = "Solo puedes seleccionar máximo 2 tipos";
            }

        });

    });
</script>
</html>
