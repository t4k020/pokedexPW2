<?php
include_once "includes/conexion.php";
/** @var mysqli $conn */
session_start();

if (!isset($_SESSION['nombre']) || $_SESSION['nombre'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 1;

$sql = "SELECT P.*, GROUP_CONCAT(T.nombre) AS tipos
FROM pokemon P
LEFT JOIN Pokemon_tipo R ON P.id = R.pokemonId
LEFT JOIN Tipo T ON T.idTipo = R.tipoId
WHERE P.id = $id";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $p = $result->fetch_assoc();

    $nombre = ucfirst($p['nombre']);
    $id_pokedex = $p['idNoIncremental'];
    $imagen = "assets/" . $p['dirImagen'];
    $tipos       = explode(",", $p['tipos']) ?? [];
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Editar Pokémon</title>

    <style>
        input[type="checkbox"]:checked + label img {
            transform: scale(1.15);
        }
    </style>
</head>
<body class="bg-secondary">

<nav class="navbar navbar-expand-md navbar-dark bg-dark border-bottom border-secondary shadow-sm">
    <div class="container d-flex justify-content-between align-items-center">
        <a class="navbar-brand d-flex align-items-center gap-2 m-0" href="index.php">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="d-inline-block align-text-top shadow-sm">
                <circle cx="12" cy="12" r="10" fill="#ffffff" stroke="#111215" stroke-width="2"/>
                <path d="M2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12H2Z" fill="#dc3545" stroke="#111215" stroke-width="2"/>
                <circle cx="12" cy="12" r="3" fill="#ffffff" stroke="#111215" stroke-width="2"/>
                <circle cx="12" cy="12" r="1" fill="#ffffff"/>
            </svg>
            <span class="fw-bold">Pokédex</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContenido">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarContenido">
            <?php if (isset($_SESSION['nombre'])): ?>
                <div class="d-flex align-items-center gap-3 text-white mt-3 mt-md-0">
                    <span>Bienvenido, <strong class="text-info"><?php echo $_SESSION['nombre']; ?></strong></span>
                    <a href="cerrarSesion.php" class="btn btn-outline-danger btn-sm">Cerrar Sesión</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            <form action="guardar.php" method="POST" enctype="multipart/form-data" class="card p-4 shadow-lg bg-dark text-white border-0">
                <h1 class="mb-4 h2 text-center fw-bold text-warning">Editar Pokémon Existente</h1>

                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="imagen_actual" value="<?php echo $p['dirImagen']; ?>">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nombre<?=((isset($_GET['error']) && $_GET['error'] == 'nombre') ?
                                '<span class="text-danger ms-2 small fw-bold">¡Ya existe ese nombre!</span>':'')?>
                        <input class="form-control bg-secondary text-white border-0 ps-3" type="text" name="nombre"
                               placeholder="Nombre del Pokémon" value="<?php echo $nombre; ?>" required>
                    </label>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">#Número Identificador
                        <?=((isset($_GET['error']) && $_GET['error'] == 'numero')?
                                '<span class="text-danger ms-2 small fw-bold">¡Ya existe ese número!</span>':'')?>
                        <input class="form-control bg-secondary text-white border-0 ps-3" type="text" name="numero" pattern="\d+" min="1"
                               placeholder="Número" value="<?php echo $id_pokedex; ?>" required>
                    </label>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Imagen</label>
                    <input class="form-control bg-secondary text-white border-0" type="file" name="imagen">
                    <div class="form-text text-muted small mt-1">Dejá este campo vacío si no vas a cambiar la imagen actual.</div>
                </div>

                <div class="mb-4">
                    <label class="form-label d-block fw-semibold">Tipos
                        <span id="error" class="text-danger ms-2 small fw-bold"></span>
                    </label>

                    <div class="d-flex flex-wrap gap-3 justify-content-center p-3 bg-black bg-opacity-25 rounded">
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

                                    <label class="btn btn-outline-light rounded-circle p-1" for="<?php echo $nombre_tipo; ?>">
                                        <img src="<?php echo $ruta_imagen; ?>" alt="<?php echo $nombre_tipo; ?>"
                                             title="<?php echo $nombre_tipo; ?>" width="40px">
                                    </label>
                                </div>
                            <?php
                            endwhile;
                        endif;
                        ?>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Habilidades
                    <div class="d-flex flex-column gap-2">
                        <input class="form-control bg-secondary text-white border-0 ps-3" type="text" name="habilidades[]"
                               placeholder="Habilidad 1" value="<?php echo $habilidades[0] ?? ""; ?>">
                        <input class="form-control bg-secondary text-white border-0 ps-3" type="text" name="habilidades[]"
                               placeholder="Habilidad 2" value="<?php echo $habilidades[1] ?? ""; ?>">
                        <input class="form-control bg-secondary text-white border-0 ps-3" type="text" name="habilidades[]"
                               placeholder="Habilidad Oculta" value="<?php echo $habilidades[2] ?? ""; ?>">
                    </div>
                    </label>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Descripción
                    <textarea class="form-control bg-secondary text-white border-0 ps-3" name="descripcion" rows="3"
                              placeholder="Descripción del Pokémon..."><?php echo $descripcion; ?></textarea>
                    </label>
                </div>

                <div class="d-flex gap-2 mt-2">
                    <a href="index.php" class="btn btn-outline-light w-50 fw-bold">Cancelar</a>
                    <button type="submit" class="btn btn-success w-50 fw-bold">GUARDAR DATOS</button>
                </div>
            </form>

        </div>
    </div>
</div>

<?php $conn->close(); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const checks = document.querySelectorAll('input[name="tipos[]"]');
    const error = document.getElementById('error'); // Declaración que faltaba

    checks.forEach(check => {
        check.addEventListener('change', () => {
            const seleccionados = document.querySelectorAll('input[name="tipos[]"]:checked');
            if (seleccionados.length > 2) {
                check.checked = false;
                error.textContent = "¡Máximo 2 tipos!";
            } else {
                error.textContent = "";
            }
        });
    });
</script>
</body>
</html>