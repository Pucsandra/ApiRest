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

    $sql = "UPDATE falleros SET nombre = ?, apellidos = ?, cuota = ?, id_falla = ? WHERE dni = ?";

    $pdoPreparada = $bd->prepare($sql);

    $objFalla = json_decode(file_get_contents("php://input"));

    $arrParametros = [
        $objFalla->nombre,
        $objFalla->apellidos,
        $objFalla->cuota,
        $objFalla->id_falla,
        $objFalla->dni,
    ];


    $dni = $objFalla->dni;
    $nombre=$objFalla->nombre;
    $apellidos=$objFalla->apellidos;
    $cuota=$objFalla->cuota;
    $id_falla=$objFalla->id_falla;

    $fallero = new Fallero($dni,$nombre,$apellidos,$cuota,$id_falla);

    $resultado = $pdoPreparada->execute($arrParametros);

    http_response_code(200); 
    
    $arrInsercion = ["mensaje" => "Fallero $dni modificado con éxito"];
    
    // definimos y enviamos el json con las fallas
    echo json_encode($arrInsercion);

    
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
