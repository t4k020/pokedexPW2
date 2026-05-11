<?php
class Pokemon {
    private static $contador = 0;
    private $id;
    private $idNoIncremental;
    private $dirImagen;
    private $nombre;
    private $tipos;
    private $descripcion;
    private $habilidades;

    public function __construct( $idNoIncremental, $dirImagen, $nombre, $tipos, $descripcion, $habilidades) {
        $this->id = ++self::$contador;
        $this->idNoIncremental = $idNoIncremental;
        $this->dirImagen = $dirImagen;
        $this->nombre = $nombre;
        $this->tipos = $tipos;
        $this->descripcion = $descripcion;
        $this->habilidades = $habilidades;
    }

    public function getId() {
        return $this->id;
    }
    public function getIdNoIncremental() {
        return $this->idNoIncremental;
    }
    public function setIdNoIncremental($idNoIncremental) {
        $this->idNoIncremental = $idNoIncremental;
    }
    public function getDirImagen() {
        return $this->dirImagen;
    }
    public function setDirImagen($dirImagen) {
        $this->dirImagen = $dirImagen;
    }
    public function getNombre() {
        return $this->nombre;
    }
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    public function getTipos() {
        return $this->tipos;
    }
    public function setTipos($tipos) {
        $this->tipos = $tipos;
    }
    public function getDescripcion() {
        return $this->descripcion;
    }
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
    public function getHabilidades() {
        return $this->habilidades;
    }
    public function setHabilidades($habilidades) {
        $this->habilidades = $habilidades;
    }
}