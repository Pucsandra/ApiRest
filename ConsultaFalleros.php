<?php

require_once 'vendor/autoload.php'; 
include_once "Conexion.php";
include_once "Fallero.php";

use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$clave = "1234";

$token = $_SERVER['HTTP_TOKEN'];

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

try {

    $objeto = new stdClass();

    $stdInfoUsuario = JWT::decode($token, new Key($clave, 'HS256'), $objeto);

    if (!$stdInfoUsuario) throw new Exception("Acceso denegado");

   $conexion = new Conexion;

   $bd=$conexion->getSbd();

    if (!$bd) throw new PDOException("Error en la conexión a la BD");

    $sql = "SELECT f.nombre, fal.nombre FROM fallas f JOIN falleros fal ON f.id_falla=fal.id_falla WHERE f.id_falla = ?";

    $queryPreparada = $bd->prepare($sql);

    $falla = (isset($_GET['id_falla']) && $_GET['id_falla']) ? $_GET['id_falla'] : '0';

    $arrParametros = [$falla];
    $queryPreparada->execute($arrParametros);
    if (!$queryPreparada->rowCount()) throw new Exception("fallas no encontradas");

    $arrFallas = [];

    while($registro = $queryPreparada->fetch()) {
    
        $regFalla = [
            'falla' => $registro[0],
            'fallero' => $registro[1]
        ];

        $arrFallas[] = $regFalla;
    }

    http_response_code(200); 

    echo json_encode($arrFallas);  
    
} catch (PDOException $e) {

    http_response_code(502); 

    $arrError = ["mensaje" => $e->getMessage()];
    echo json_encode($arrError);

} catch (Exception $e) {

    http_response_code(403); 

    $arrError = ["mensaje" => $e->getMessage()];
    echo json_encode($arrError);

}
?>
