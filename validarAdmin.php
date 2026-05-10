<?php
session_start();
$conn = new mysqli("localhost", "root", "", "pokedex");

$user = $_POST['usuario'];
$pass = $_POST['pass'];

$stmt = $conn->prepare("SELECT id, password FROM usuario WHERE username = ?");
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    if ($pass == $row['password']) {
        $_SESSION['id'] = $row['id'];
        $_SESSION['nombre'] = $user;
        header("Location: index.php");
        exit();
    }
     else {
        echo "Contraseña incorrecta";
    }
}else {
    echo "Usuario no encontrado";
}