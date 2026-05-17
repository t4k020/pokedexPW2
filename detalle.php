<?php
session_start();
require_once "clases/Pokemon.php";
include_once "includes/conexion.php";
$id = isset($_GET['id']) ? intval($_GET['id']) : 1;
$sql = "SELECT P.*, GROUP_CONCAT(T.nombre) AS tipos
FROM pokemon P
LEFT JOIN Pokemon_tipo R ON P.id = R.pokemonId
LEFT JOIN Tipo T ON T.idTipo = R.tipoId
WHERE P.id = $id";

/** @var mysqli $conn */
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $fila = $result->fetch_assoc();
    $p = new Pokemon($fila);
    $descripcion = isset($fila['descripcion']) ? $fila['descripcion'] : "Sin descripción disponible.";
} else {
    die("¡Pokémon no encontrado en la DB!");
}
?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Detalle de <?php echo $p->nombre; ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        <style>

            .pokemon-types img {
                width: 45px !important;
                height: 45px !important;
                margin: 0 4px;
                object-fit: contain;
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
                <?php else: ?>
                    <form action="validarAdmin.php" class="d-flex flex-column flex-md-row gap-2 mt-3 mt-md-0" method="POST">
                        <input class="form-control form-control-sm bg-secondary text-white border-0" type="text" name="usuario" placeholder="Usuario" required>
                        <input class="form-control form-control-sm bg-secondary text-white border-0" type="password" name="pass" placeholder="Contraseña" required>
                        <button class="btn btn-primary btn-sm fw-bold" type="submit">Ingresar</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="card bg-dark text-white shadow-lg border-0 mx-auto position-relative" style="max-width: 850px;">

            <?php if (isset($_SESSION['nombre']) && $_SESSION['nombre'] === 'admin'): ?>
                <div class="position-absolute top-0 end-0 p-3 d-flex gap-2" style="z-index: 10;">
                    <a href="editar_formulario.php?id=<?php echo $p->id; ?>" class="btn btn-warning btn-sm fw-bold shadow">
                        <i class="bi bi-pencil-fill"></i> Editar
                    </a>
                    <a href="borrar.php?id=<?php echo $p->id; ?>&img=<?php echo urlencode($p->dirImagen); ?>"
                       class="btn btn-danger btn-sm fw-bold shadow" onclick="return confirm('¿Seguro querés borrar este Pokémon?')">
                        <i class="bi bi-trash-fill"></i> Borrar
                    </a>
                </div>
            <?php endif; ?>

            <div class="row g-0 align-items-center">
                <div class="col-12 col-md-5 text-center p-4 bg-black bg-opacity-25 rounded-start-md h-100">
                    <img src="<?php echo $p->dirImagen; ?>" alt="<?php echo $p->nombre; ?>" class="img-fluid my-3" style="max-height: 250px;">
                    <div class="badge bg-secondary fs-5 shadow-sm mt-2">#<?php echo $p->idNoIncremental; ?></div>
                </div>

                <div class="col-12 col-md-7 p-4 p-md-5">
                    <h1 class="text-transform-capitalize fw-bold mb-2 display-5"><?php echo $p->nombre; ?></h1>

                    <div class="pokemon-types mb-4">
                        <?php $p->imprimirTipos(); ?>
                    </div>

                    <div class="p-3 bg-secondary bg-opacity-25 rounded border-start border-warning border-3 mb-4 fst-italic">
                        "<?php echo $descripcion; ?>"
                    </div>

                    <h3 class="h5 fw-bold mb-3"><i class="bi bi-lightning-charge-fill text-warning"></i> Habilidades de combate</h3>
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <?php foreach ($p->habilidades as $h): ?>
                            <span class="badge bg-secondary fs-6 px-3 py-2 text-capitalize shadow-sm">
                            <?php echo $h; ?>
                        </span>
                        <?php endforeach; ?>
                    </div>

                    <hr class="border-secondary mb-4">

                    <a href="index.php" class="btn btn-outline-light px-4 fw-bold shadow-sm">
                        <i class="bi bi-arrow-left"></i> Volver al Inicio
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
<?php $conn->close(); ?>