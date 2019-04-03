<?php
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

//Librerias desde composer
require_once '../vendor/autoload.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'GET':
        checkUser();
        break;
    default:
        # code...
        break;
}

function checkUser(){
    $res = new ResponseDTO();
    $userBusinessImpl = new UserBusinessImpl();
    $userDTO = new UserDTO();

    //Inputs de la peticion
    $data = json_decode(file_get_contents("php://input"));

    try {
        //Confirma que la petición es correcta
        if (  empty($data->username) ) {
            $res->setCode("RSP_01");
            $res->setMessage("Faltaron datos");
            throw new Exception();
        }

        //Busca usuario por username
        try {
            $userDTO = $userBusinessImpl->findByUsername($data->username);
        } catch (Exception $th) {
            $res->setCode("RSP_06");
            $res->setMessage("No fue posible verificar existencia por username");
            throw new Exception();
        }

        //Verifica si la busqueda por username regreso algun valor
        if ($userDTO !== null) {
            $res->setCode("RSP_02");
            $res->setMessage("El nombre de usuario ya esta en uso");
            $res->setResponse(true);
        } else {
            $res->setCode("RSP_00");
            $res->setMessage("El nombre de usuario esta disponible");
            $res->setResponse(false);
        }
        //Establece respuesta OK
        http_response_code(200);
        
    } catch (Exception $e) {
        http_response_code(201);
    } finally {
        echo json_encode($res);
    }
}