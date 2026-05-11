<?php
class Tipo {
    private $nombre;
    private $dirImagen;
    private $color;

    public function __construct($nombre,$dirImagen,$color) {
        $this->nombre = $nombre;
        $this->dirImagen = $dirImagen;
        $this->color = $color;
    }

    public function getNombre() {
        return $this->nombre;
    }
    public function getDirImagen() {
        return $this->dirImagen;
    }
    public function getColor() {
        return $this->color;
    }
}