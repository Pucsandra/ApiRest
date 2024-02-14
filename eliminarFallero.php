<?php

require_once 'vendor/autoload.php'; 
include_once "Conexion.php";

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

    if (!$bd) throw new Exception("Error en la conexión a la BD");

    $sql = "DELETE FROM falleros WHERE dni = ?;";

    $pdoPreparada = $bd->prepare($sql);
    $arrParametros = [
        $objFalla->dni
    ];


    $id = $objFalla->dni;

    $resultado = $pdoPreparada->execute($arrParametros);

    if (!$resultado) throw new Exception('No se ha podido realizar la actualización.<br>');
    
    // definimos la cabecera HTTP con código OK
    http_response_code(200); 

    // respuesta de inserción realizada con éxito
    $arrInsercion = ["mensaje" => "Fallero $id eliminada con éxito"];
    
    // definimos y enviamos el json con las fallas
    echo json_encode($arrInsercion);
  
} catch (PDOException $e) {

    http_response_code(400); 

    $arrError = ["mensaje" => $e->getMessage()];
    echo json_encode($arrError);

} catch (Exception $e) {

    http_response_code(400); 

    $arrError = ["mensaje" => $e->getMessage()];
    echo json_encode($arrError);
}
?>
