<?php
$token = $_SERVER['HTTP_TOKEN'];
//$token = $_SERVER['HTTP_AUTHORIZATION'];

// creamos la cabecera para indicar que vamos a devolver un recurso REST
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

try {

    // creamos un objeto de la clase stdClass con el algoritmo
    $objeto = new stdClass();

    // intentamos decodificar el token
    $stdInfoUsuario = JWT::decode($token, new Key($clave, 'HS256'), $objeto);

    // si el token no es válido, no se permite el acceso al servicio web
    if (!$stdInfoUsuario) throw new Exception("Acceso denegado");
}catch (Exception $e) {

    // definimos la cabecera HTTP con el código de error
    http_response_code(400); 

    // definimos y enviamos el array con el mensaje de error
    $arrError = ["mensaje" => $e->getMessage()];
    echo json_encode($arrError);

}
?>