<?php

/* La clase fallero tiene los atributos dni, nombre apellidos, 
cuota y id_falla con sus respectivos gets y sets. */
class Fallero{

    private $dni;
    private $nombre;
    private $apellidos;
    private $cuota;
    private $idFalla;

    function __construct($dni,$nombre,$apellidos,$cuota,$idFalla) {
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->cuota = $cuota;
        $this->idFalla = $idFalla;

    }

    public function getDni() {
        return $this->dni;
    }

    public function setDni($dni) {
        $this->dni = $dni;
    }
    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    public function getApellidos() {
        return $this->apellidos;
    }

    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }
    public function getCuota($resultadoPresupuesto) {
        /* Formato de la cuota */
        return $this->cuota=number_format($resultadoPresupuesto,2,',','.');
    }

    public function setCuota($cuota) {
        $this->cuota = $cuota;
    }
    public function getId_falla() {
        return $this->idFalla;
    }

    public function setId_falla($idFalla) {
        $this->idFalla = $idFalla;
    }


    public function  __toString() {
        return "Fallero: $this->dni $this->nombre $this->apellidos $this->cuota $this->idFalla";
    }
}
?>