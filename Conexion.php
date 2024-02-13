<?php
class Conexion{
    private $dbname;
    private $host;
    private $usuario;
    private $contrasenya;
    private $strConexion;
    private $sbd;


    function __construct() {
        $this->dbname ='fallas_valencia';
        $this->host = "localhost";
        $this->usuario = 'sandra';
        $this->contrasenya = '123';
        $this->strConexion = "mysql:dbname=$this->dbname;host=$this->host";
        $this->sbd = new PDO($this->strConexion, $this->usuario, $this->contrasenya);
    }
    public function getDbname() {
        return $this->dbname;
    }

    public function setDbname($dbname) {
        $this->dbname = $dbname;
    }
    public function getHost() {
        return $this->host;
    }

    public function setHost($host) {
        $this->host = $host;
    }
    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
    public function getContrasenya() {
        return $this->contrasenya;
    }

    public function setContrasenya($contrasenya) {
        $this->contrasenya = $contrasenya;
    }
    public function getStrConexion() {
        return $this->strConexion;
    }

    public function setStrConexion($strConexion) {
        $this->strConexion = $strConexion;
    }
    public function getSbd() {
        return $this->sbd;
    }

    public function setSdb($sbd) {
        $this->sbd = $sbd;
    }

}

?>