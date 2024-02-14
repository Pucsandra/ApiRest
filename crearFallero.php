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

    if (!$bd) throw new Exception("Error en la conexión a la BD");

    $sql = "insert into falleros (dni, nombre, apellidos, cuota, id_falla) values (?, ?, ?, ?, ?);";

    $pdoPreparada = $bd->prepare($sql);

    $arrParametros = [
        $_POST['dni'],
        $_POST['nombre'],
        $_POST['apellidos'],
        $_POST['cuota'],
        $_POST['id_falla'],
    ];

    $fallero = new Fallero($_POST['dni'],$_POST['nombre'],$_POST['apellidos'],$_POST['cuota'],$_POST['id_falla']);
    $resultado = $pdoPreparada->execute($arrParametros);

    if (!$resultado) throw new Exception('No se ha podido realizar la inserción.<br>');

    http_response_code(200); 

    $arrInsercion = ["mensaje" => 'Fallero ' .$_POST['dni'] .' creada con éxito'];

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
