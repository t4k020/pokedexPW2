<?php
session_start();
$conn = new mysqli("localhost", "root", "", "pokedex");

$user = $_POST['usuario'];
$pass = $_POST['pass'];

$stmt = $conn->prepare("SELECT id, password FROM usuario WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

$error_msg = "";

if ($row = $result->fetch_assoc()) {
    if ($pass == $row['password']) {
        $_SESSION['id'] = $row['id'];
        $_SESSION['nombre'] = $user;
        header("Location: index.php");
        exit();
    } else {
        $error_msg = "Contraseña incorrecta. Volvé a intentarlo.";
    }
} else {
    $error_msg = "El usuario ingresado no existe.";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error de Ingreso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-secondary d-flex align-items-center justify-content-center vh-100">

<div class="container d-flex justify-content-center">
    <div class="card bg-dark text-white p-4 shadow-lg text-center border-0" style="max-width: 400px; width: 100%;">

        <div class="mb-3">
            <i class="bi bi-exclaim-triangle-fill text-danger display-4"></i>
        </div>

        <h2 class="h4 fw-bold mb-3">Error de Conexión</h2>

        <div class="alert alert-danger py-2 shadow-sm fw-semibold" role="alert">
            <?php echo $error_msg; ?>
        </div>

        <hr class="border-secondary my-3">

        <a href="index.php" class="btn btn-warning w-100 fw-bold text-dark shadow-sm">
            <i class="bi bi-arrow-left"></i> Volver a intentar
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>