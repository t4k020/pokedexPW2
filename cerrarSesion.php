<?php
session_start();
session_destroy();
header("Location: pokedex.php");
exit();
?>