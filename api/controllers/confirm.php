<?php
// error_reporting(E_ALL); ?
// ini_set('display_errors', '1'); ?

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Conexión a la base de datos
include_once '../config/database.php';

//Entidades
include_once '../entity/User.php';

//DTO's
include_once '../dto/UserDTO.php';
include_once '../dto/ResponseDTO.php';

//Interfaces de businesses
include_once '../business/UserBusiness.php';

//Businesses
include_once '../business/implementation/UserBusinessImpl.php';
include_once '../business/implementation/TokenBusinessImpl.php';
include_once '../business/implementation/EmailBusinessImpl.php';

//Librerias desde composer
require_once '../vendor/autoload.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'GET':
        confirmEmailToken();
        break;

    default:
        # code...
        break;

}

function confirmEmailToken()
{
    $res = new ResponseDTO();
    $userDTO = new UserDTO();
    $userBusinessImpl = new UserBusinessImpl();
    $tokenBusinessImpl = new TokenBusinessImpl();

    //Inputs de la peticion
    $data = json_decode(file_get_contents("php://input"));

    //Obtener emailToken
    $emailToken = $_GET['token'];

    try {
        //Comprovar que la peticion sea correcta
        if (
            empty($emailToken)
        ) {
            $res->setCode("RSP_??");
            $res->setMessage("Necesitas un emailToken para confirmar tu cuenta");
            throw new Exception("No tienes autorización");
        }

        //Comprobar que el emailToken exista
        try {
            $userDTO = $userBusinessImpl->findByEmailToken($emailToken);
        } catch (Exception $th) {
            $res->setCode("RSP_??");
            $res->setMessage("Token invalido. No tienes autorización");
            throw new Exception();
        }

        //Actualizar usuario en base de datos
        try {
            $userDTO->setVerify(true);
            $userBusinessImpl->update($userDTO);
        } catch (Exception $e) {
            $res->setCode("RSP_??");
            $res->setMessage("Error al persistir");
            throw new Exception();
        }

        //Establecer respuesta OK
        http_response_code(200);
        $res->setCode("RSP_00");
        $res->setMessage("Respuesta exitosa");
        echo json_encode($res);
        header("Location: http://localhost/web/register.html?confirmed=''true");
        die();

    } catch (Exception $e) {
        http_response_code(201);
        echo json_encode($res);
    }
}
