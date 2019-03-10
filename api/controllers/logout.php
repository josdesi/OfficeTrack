<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';

include_once '../entity/Session.php';

include_once '../dto/SessionDTO.php';
include_once '../dto/ResponseDTO.php';

include_once '../business/UserBusiness.php';
include_once '../business/SessionBusiness.php';

include_once '../business/implementation/UserBusinessImpl.php';
include_once '../business/implementation/SessionBusinessImpl.php';
include_once '../business/implementation/TokenBusinessImpl.php';

require_once('../vendor/autoload.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

switch ($requestMethod) {
    case 'POST':
        logout();
        break;
    
    default:
        break;
}

function logout(){

    $userBusiness = new UserBusinessImpl();
    $tokenBusinessImpl = new TokenBusinessImpl();
    $sessionBusinessImpl = new SessionBusinessImpl();

	$res = new ResponseDTO();
    $sessionDTO = new SessionDTO();

    //Obtener el header de autorizacion
    $data = json_decode(file_get_contents("php://input"));
    $bearerToken = getallheaders()["Authorization"];
    $sessionToken = substr ( $bearerToken, 7);

     try {
        //Comprobar el header de autorización no este vacio
        if (
            empty($sessionToken)
       ) {
           $res->setCode("RSP_??");
           $res->setMessage("Necesitas un token de session para cerrar sesión");
           throw new Exception("Body Request Error");
       }

        //Validar token de autorizacion
        try {
            //Si el token es valido, la función retorna el payload, de lo contrario lanza una excepción
            $tokenPayload = $tokenBusinessImpl->decodeSessionToken($sessionToken);
        } catch (Exception $th) {
            $res->setCode("RSP_??");
            $res->setMessage("Token invalido. No tienes autorización");
            throw new Exception();
        }

        //Eliminar sesiones en la tabla sessions
        try {
            $payloadData = (array) $tokenPayload->data;
            $userId = $payloadData['userId'];
            $sessionType = $payloadData['sessionType'];

            $sessionDTO->setUserId($userId);
            $sessionDTO->setSessionType($sessionType);

            $sessionBusinessImpl->deleteSession($sessionDTO);
        } catch (Exception $th) {
            $res->setCode("RSP_??");
            $res->setMessage("No fue posible cerrar sesión");
            throw new Exception();
        }

        http_response_code(200);
        $res->setCode("RSP_00");
        $res->setMessage("La sesión se ha cerrado correctamente");
        echo json_encode($res);


    } catch (Exception $e) {
        http_response_code(201);
        echo json_encode($res);
    }

}
?>