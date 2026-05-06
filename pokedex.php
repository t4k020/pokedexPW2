<?php


$conn = new mysqli("localHost", "root", "", "pokedex");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// 2. Obtener un Pokémon aleatorio de la base de datos
// Usamos ORDER BY RAND() para obtener uno al azar y LIMIT 1
$sql = "SELECT * FROM pokemon ORDER BY idNoIncremental ASC";
$result = $conn->query($sql);




?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokémon Aleatorio</title>
    <style>
        .navbar {
            display: flex;
            justify-content: space-between; /* Separa los 3 grupos */
            align-items: center;           /* Centra verticalmente */
            width: 100%;
            background-color: #333;
            color: white;
            font-family: Arial, sans-serif;
            height: 3em;
            padding-top 10px;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-logo img {
            border-radius: 50%;
        }

        .logo-name {
            font-weight: bold;
            font-size: 1.2rem;
        }

        .nav-title h1 {
            font-size: 1.1rem;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .nav-form {
            display: flex;
            gap: 8px;
        }

        .nav-form input {
            padding: 5px 10px;
            border-radius: 4px;
            border: none;
        }

        .nav-form button {
            padding: 5px 15px;
            background-color: #e67e22; /* Color naranja vikingo */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }

        .nav-search {
            display: flex;
            align-items: center;
            background-color: #fff; /* Fondo blanco para el buscador */
            border-radius: 20px;    /* Bordes redondeados estilo Google/Pokedex */
            padding: 2px 5px;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        /* Efecto cuando el usuario hace clic para escribir */
        .nav-search:focus-within {
            border-color: #e67e22; /* Color naranja vikingo al enfocar */
            box-shadow: 0 0 8px rgba(230, 126, 34, 0.4);
        }

        /* El campo de texto */
        .nav-search input[type="search"] {
            border: none;
            background: none;
            outline: none;
            padding: 8px 12px;
            font-size: 0.9rem;
            width: 200px; /* Ancho ajustable */
            color: #333;
        }

        /* El botón de buscar */
        .nav-search button {
            background-color: #e67e22;
            color: white;
            border: none;
            border-radius: 15px; /* Redondeado pero dentro del form */
            padding: 6px 15px;
            cursor: pointer;
            font-weight: bold;
            font-size: 0.85rem;
            transition: background 0.2s;
        }

        .nav-search button:hover {
            background-color: #d35400;
        }

        /* Quitar la "X" que aparece por defecto en navegadores en inputs search */
        .nav-search input::-webkit-search-decoration,
        .nav-search input::-webkit-search-cancel-button,
        .nav-search input::-webkit-search-results-button,
        .nav-search input::-webkit-search-results-decoration {
            display: none;
        }

        .nav-search {
            display: flex;
            align-items: center;
            background-color: #fff; /* Fondo blanco para el buscador */
            border-radius: 20px;    /* Bordes redondeados estilo Google/Pokedex */
            padding: 2px 5px;
            border: 2px solid transparent;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        body {
            font-family: 'Arial', sans-serif;
            background: #e0e0e0; display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;  margin: 0;
            width: 100%;
        }


        .card {
            background: white; border-radius: 20px; padding: 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            text-align: center; width: 300px; border-top: 10px solid #ef5350;
        }

        .pokemon-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .card-actions {
            position: relative;
            top: 10px;
            right: 10px;
            display: flex;
            gap: 8px;
            z-index: 10;
        }

        /* Estilo base para los botones redondos */
        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.1rem;
            transition: transform 0.2s, background 0.2s;
            color: white;
        }

        .btn-action:hover {
            transform: scale(1.1);
        }

        /* Colores específicos */
        .edit {
            background-color: #3498db; /* Azul */
        }

        .delete {
            background-color: #e74c3c; /* Rojo */
        }

        .edit:hover { background-color: #2980b9; }
        .delete:hover { background-color: #c0392b; }

        img { width: 200px; height: 200px; filter: drop-shadow(0 5px 5px #ccc); }

        h1 { text-transform: capitalize; margin: 10px 0; color: #333; }

        .tipo {
            background: #78c850; color: white; padding: 5px 15px; border-radius: 50px;
            font-size: 12px; font-weight: bold; text-transform: uppercase; margin: 2px; display: inline-block;
        }

        ul { text-align: left; padding-left: 20px; color: #555; }
        li { text-transform: capitalize; margin-bottom: 5px; }

        /* Estilo del Botón */
        .btn-random {
            margin-top: 20px; padding: 12px 25px; font-size: 16px; font-weight: bold;
            color: white; background: #3b4cca; border: none; border-radius: 50px;
            cursor: pointer; transition: 0.3s; box-shadow: 0 4px #2a3795;
        }

        .btn-random:hover { background: #4a5ae0; }
        .btn-random:active { box-shadow: 0 2px #2a3795; transform: translateY(2px); }
    </style>
</head>
<body>

<nav class="navbar">
    <!-- Lado Izquierdo: Imagen y Nombre del Logo -->
    <div class="nav-logo">
        <img src="https://via.placeholder.com/40" alt="Logo">
        <span class="logo-name">Poke dex</span>
    </div>

    <!-- Centro: Título -->
    <div class="nav-title">
        <h1>Gestión de Aldea</h1>
    </div>

    <!-- Lado Derecho: Formulario de Ingreso -->
    <form class="nav-form">
        <input type="text" placeholder="Usuario" required>
        <input type="password" placeholder="Contraseña" required>
        <button type="submit">Ingresar</button>
    </form>
</nav>

<form class="nav-search" action="buscar.php" method="GET">
    <input type="search" name="q" placeholder="Buscar pokimon">
    <button type="submit">Buscar</button>
</form>

<div class="pokemon-grid">
    <?php
    // 3. El Bucle Mágico: Mientras haya filas en la DB, crea una carta
    if ($result->num_rows > 0):
        while($row = $result->fetch_assoc()):

            // Procesamos los datos de la fila actual
            $ruta_imagen = "assets/" . $row['dirImagen'];
            $tipos = array_filter([$row['tipo1'], $row['tipo2']]); // Crea array y quita nulos
            $habilidades = array_filter([$row['habilidad1'], $row['habilidad2'], $row['habilidad3'], $row['habilidad4']]);
            ?>

            <div class="card">
                <div class="card-actions">
                    <a href="editar.php?id=<?php echo $row['id']; ?>" class="btn-action edit">✎</a>
                    <a href="borrar.php?id=<?php echo $row['id']; ?>" class="btn-action delete" onclick="return confirm('¿Borrar?')">×</a>
                </div>

                <a href="detalle.php?id=<?php echo $row['id']; ?>">
                    <img src="<?php echo $ruta_imagen; ?>" alt="<?php echo $row['nombre']; ?>">
                </a>

                <p style="color: #888; margin: 0;">#<?php echo $row['idNoIncremental']; ?></p>
                <h2 style="text-transform: capitalize; margin: 10px 0;"><?php echo $row['nombre']; ?></h2>

                <div>
                    <?php foreach ($tipos as $t): ?>
                        <span class="tipo"><?php echo $t; ?></span>
                    <?php endforeach; ?>
                </div>

                <div style="text-align: left; margin-top: 15px; font-size: 0.9rem;">
                    <strong>Habilidades:</strong>
                    <ul style="padding-left: 20px; margin: 5px 0;">
                        <?php foreach ($habilidades as $h): ?>
                            <li style="text-transform: capitalize;"><?php echo $h; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

        <?php
        endwhile;
    else:
        echo "<p>No hay Pokémon en la base de datos.</p>";
    endif;
    $conn->close();
    ?>
</div>


<button class="btn-random" onclick="">
    CREAR POKEMON
</button>

</body>
</html>
