<?php

/* La clase falla tiene los atributos id_falla, nombre y 
presupuesto con sus respectivos gets y sets. */
class Falla{

    private $id_falla;
    private $nombre;
    private $presupuesto;

    function __construct($id_falla,$nombre,$presupuesto) {
        $this->id_falla = $id_falla;
        $this->nombre = $nombre;
        $this->presupuesto = $presupuesto;
    }

    public function getId_falla() {
        return $this->id_falla;
    }

    public function setId_falla($id_falla) {
        $this->id_falla = $id_falla;
    }
    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    public function getPresupuesto($presupuesto) {
        return $this->presupuesto=number_format($presupuesto,2,',','.');
    }

    public function setPresupuesto($presupuesto) {
        $this->presupuesto = $presupuesto;
    }
    public function  __toString() {
        return "Falla: $this->id_falla $this->nombre $this->presupuesto";
    }
   
}

?>