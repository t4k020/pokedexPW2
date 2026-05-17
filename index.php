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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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

    <div class="row mb-4 justify-content-center">
        <div class="col-12 col-md-6">
            <form action="buscar.php" method="GET">
                <div class="input-group shadow">
                    <input type="search" name="termino" class="form-control bg-dark text-white border-secondary ps-3" placeholder="Buscar Pokémon por nombre o número...">
                    <button class="btn btn-warning fw-bold text-dark px-4" type="submit">Buscar</button>
                </div>
            </form>
        </div>
    </div>

    <?php if (isset($_SESSION['nombre']) && $_SESSION['nombre'] === 'admin'): ?>
        <div class="text-center mb-5">
            <a class="btn btn-success fw-bold shadow px-4 py-2" href="crear_formulario.php">
                <i class="bi bi-plus-circle-fill me-2"></i>CREAR POKEMON
            </a>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <?php
        if ($result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
                $p = new Pokemon($row);
                ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 bg-dark text-white text-center p-3 border-0 shadow">

                        <a href="detalle.php?id=<?php echo $p->id; ?>">
                            <img src="<?php echo $p->dirImagen; ?>" alt="<?php echo $p->nombre; ?>" class="img-fluid">
                        </a>

                        <p style="color: #888; margin: 0; margin-top: 10px;">#<?php echo $p->idNoIncremental; ?></p>
                        <h2 style="text-transform: capitalize; margin: 10px 0; font-size: 1.75rem;" class="fw-bold"><?php echo $p->nombre; ?></h2>

                        <div class="mb-3">
                            <?php $p->imprimirTipos(); ?>
                        </div>

                        <div class="habilidades mt-auto text-center">
                            <strong class="text-secondary">Habilidades:</strong>
                            <ul class="list-unstyled text-center mb-0 mt-1">
                                <?php foreach ($p->habilidades as $h): ?>
                                    <li style="text-transform: capitalize; font-size: 0.95rem; color: #ccc;"><?php echo $h; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                    </div> </div> <?php
            endwhile;
        endif;
        ?>
    </div> </div> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>