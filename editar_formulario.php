<?php
include_once "includes/conexion.php";
session_start();

if (!isset($_SESSION['nombre']) || $_SESSION['nombre'] !== 'admin') {


    header("Location: index.php");


    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$sql = "SELECT * FROM pokemon WHERE id = $id";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $p = $result->fetch_assoc();

    $nombre = ucfirst($p['nombre']);
    $id_pokedex = $p['idNoIncremental'];
    $imagen = "assets/" . $p['dirImagen'];
    $tipos       = array_filter([$p['tipo1'], $p['tipo2']]);
    $habilidades = array_filter([$p['habilidad1'], $p['habilidad2'], $p['habilidad3']]);
    $descripcion = $p['descripcion'];

} else {
    die("¡Pokémon no encontrado en la DB!");
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
        <input type="hidden" name="imagen_actual" value="<?php echo $p['dirImagen']; ?>">

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input class="form-control" type="text" name="nombre"
                   placeholder="Nombre del Pokémon" value="<?php echo $nombre; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">#Número Identificador</label>
            <input class="form-control" type="text" name="numero" pattern="\d+" min="1"
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
                if ($result_tipos->num_rows > 0) :
                    while ($row = $result_tipos->fetch_assoc()) :

                        $id_tipo = $row["idTipo"];
                        $nombre_tipo = $row["nombre"];
                        $ruta_imagen = "Assets/Tipo/" . $row["dirImagen"];
                        ?>

                        <div>
                            <input type="checkbox" class="btn-check" id="<?php echo $nombre_tipo; ?>"
                                   name="tipos[]" value="<?php echo $nombre_tipo; ?>"
                                <?php echo in_array($nombre_tipo, $tipos) ? 'checked' : ''; ?>>

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
    </form>
</div>

<!--    Datos extras??-->

<?php $conn->close(); ?>
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

