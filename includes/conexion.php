<?php

$conn = new mysqli("localHost", "root", "", "pokedex");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}