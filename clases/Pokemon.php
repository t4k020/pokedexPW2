<?php

class Pokemon
{
    public $id;
    public $idNoIncremental;
    public $nombre;
    public $dirImagen;
    public $tipos = [];
    public $habilidades = [];

    public function __construct($row)
    {
        $this->id = $row['id'];
        $this->idNoIncremental = $row['idNoIncremental'];
        $this->nombre = $row['nombre'];
        $this->dirImagen = "assets/" . $row['dirImagen'];

        // Limpiamos tipos y habilidades (filtramos nulos/vacíos)
        $this->tipos = explode(",", $row['tipos']) ?? [];
        $this->habilidades = array_filter([$row['habilidad1'], $row['habilidad2'], $row['habilidad3']]);
    }

    // Un método para no repetir el HTML de los tipos
    public function imprimirTipos()
    {
        foreach ($this->tipos as $t) {
            echo "<img class='tipo' src='assets/tipo/$t.svg' alt='$t' title='$t'>";
        }
    }
}