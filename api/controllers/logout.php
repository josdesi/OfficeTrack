<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Conexión a la base de datos
include_once '../config/database.php';

//Entidades
include_once '../entity/Session.php';

//DTO's
include_once '../dto/SessionDTO.php';
include_once '../dto/ResponseDTO.php';

//Interfaces de businesses
include_once '../business/UserBusiness.php';
include_once '../business/SessionBusiness.php';

//Businesses
include_once '../business/implementation/UserBusinessImpl.php';
include_once '../business/implementation/SessionBusinessImpl.php';
include_once '../business/implementation/TokenBusinessImpl.php';

//Librerias desde composer
require_once '../vendor/autoload.php';

$requestMethod = $_SERVER["REQUEST_METHOD"];

switch ($requestMethod) {
    case 'POST':
        logout();
        break;

    default:
        break;
}

function logout()
{

    $userBusiness = new UserBusinessImpl();
    $tokenBusinessImpl = new TokenBusinessImpl();
    $sessionBusinessImpl = new SessionBusinessImpl();

    $res = new ResponseDTO();
    $sessionDTO = new SessionDTO();

    //Obtener el header de autorizacion
    $data = json_decode(file_get_contents("php://input"));
    $bearerToken = getallheaders()["Authorization"];
    $sessionToken = substr($bearerToken, 7);

    try {
        //Comprobar que el header de autorización no este vacio
        if (
            empty($sessionToken)
        ) {
            $res->setCode("RSP_01");
            $res->setMessage("Necesitas un token de session para cerrar sesión");
            throw new Exception("No tienes autorización");
        }

        //Validar token de autorizacion
        try {
            //Si el token es valido, la función retorna un objeto payload, de lo contrario lanza una excepción
            $tokenPayload = $tokenBusinessImpl->decodeSessionToken($sessionToken);
        } catch (Exception $th) {
            $res->setCode("RSP_03");
            $res->setMessage("Token invalido. No tienes autorización");
            throw new Exception();
        }

        //Eliminar sesiones en la tabla sessions
        try {
            $userId = $tokenPayload->data->userId;
            $sessionType = $tokenPayload->data->sessionType;

            $sessionDTO->setUserId($userId);
            $sessionDTO->setSessionType($sessionType);

            $sessionBusinessImpl->delete($sessionDTO);
        } catch (Exception $th) {
            $res->setCode("RSP_07");
            $res->setMessage("Error en la persistencia");
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
