<?php
require_once "Classes/tipos.php";
require_once "Classes/pokemones.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!empty($pokemones)) {
    foreach ($pokemones as $pokemon) {
        if ($pokemon->getId() == $id) {
            $nombre = ucfirst($pokemon->getNombre());
            $id_pokedex = $pokemon->getIdNoIncremental();
            $imagen = "assets/" . $pokemon->getDirImagen();
            $tipos = $pokemon->getTipos();
            $habilidades = $pokemon->getHabilidades();
            $descripcion = $pokemon->getDescripcion();
        }
    }

} else
    die("¡Pokémon no encontrado en la DB!");

?>

<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Editar Pokemon</title>

    <style>
        input[type="checkbox"]:checked + label img {
            transform: scale(1.15);
        }
    </style>

</head>
<body class="bg-light">
<div class="container py-5">
    <form action="guardar.php" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
        <h1 class="mb-4">Editar Pokemon Existente</h1>

        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <input type="hidden" name="imagen_actual" value="<?php echo $imagen; ?>">

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input class="form-control" type="text" name="nombre"
                   placeholder="Nombre del Pokémon" value="<?php echo $nombre; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">#Número Identificador</label>
            <input class="form-control" type="text" name="numero"
                   placeholder="Número" value="<?php echo $id_pokedex; ?>" required>
        </div>

        <div class="mb-4">
            <label class="form-label">Imagen</label>
            <input class="form-control" type="file" name="imagen">
        </div>

        <div class="mb-4">
            <label class="form-label d-block">Tipos
                <span id="error" class="text-danger ms-2"></span>
            </label>


            <div class="d-flex flex-wrap gap-3 justify-content-center">

                <?php
                if (isset($tipos) && !empty($tipos)):
                    foreach ($tipos as $tipo) :
                        $nombre_tipo = $tipo->getNombre();
                        $ruta_imagen = "Assets/Tipo/" . $tipo->getDirImagen();
                        ?>

                        <div>
                            <input type="checkbox" class="btn-check" id="<?php echo $nombre_tipo; ?>"
                                   name="tipos[]" value="<?php echo $nombre_tipo; ?>">

                            <label class="btn btn-outline-dark rounded-circle p-1" for="<?php echo $nombre_tipo; ?>">
                                <img src="<?php echo $ruta_imagen; ?>" alt="<?php echo $nombre_tipo; ?>"
                                     title="<?php echo $nombre_tipo; ?>" width="40px"></label>
                        </div>

                    <?php
                    endforeach;
                endif;
                ?>

            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Habilidades</label>
            <input class="form-control" type="text" name="habilidades[]"
                   placeholder="Habilidad 1" value="<?php echo $habilidades[0] ?? ""; ?>">
            <input class="form-control" type="text" name="habilidades[]"
                   placeholder="Habilidad 2" value="<?php echo $habilidades[1] ?? ""; ?>">
            <input class="form-control" type="text" name="habilidades[]"
                   placeholder="Habilidad Oculta" value="<?php echo $habilidades[2] ?? ""; ?>">
        </div>

        <div class="mb-4">
            <label class="form-label">Descripción</label>
            <textarea class="form-control" name="descripcion" rows="3"
                      placeholder="Descripción del Pokémon" ><?php echo $descripcion; ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">
            <b>GUARDAR DATOS</b>
        </button>

</div>
</form>
<!--    Datos extras??-->
</div>
</body>
<script>
    const checks = document.querySelectorAll('input[name="tipos[]"]');

    checks.forEach(check => {

        check.addEventListener('change', () => {

            const seleccionados =
                document.querySelectorAll('input[name="tipos[]"]:checked');

            if (seleccionados.length > 2) {
                check.checked = false;
                error.textContent = "Solo puedes seleccionar máximo 2 tipos";
            }

        });

    });
</script>
</html>

