<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');

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
    case 'POST':
        recoverPass();
        break;

    default:
        # code...
        break;
}

function recoverPass(){
    $res = new ResponseDTO();
    $userBusinessImpl = new UserBusinessImpl();
    $tokenBusinessImpl = new TokenBusinessImpl();
    $emailBusinessImpl = new EmailBusinessImpl();
    $userDTO = new UserDTO();

    //Input de la peticion
    $data = json_decode(file_get_contents("php://input"));

    try {

        //Confirma que la petición es correcta
        if ( empty($data->email) ) {
            $res->setCode("RSP_01");
            $res->setMessage("Faltaron datos");
            throw new Exception();
        }

        //Busca usuario por email
        try {
            $userDTO = $userBusinessImpl->findByEmail($data->email);
        } catch (Exception $th) {
            $res->setCode("RSP_03");
            $res->setMessage("No fue posible verificar existencia por email");
            throw new Exception();
        }

        //Verifica si la busqueda por email regreso algun valor
        if ($userDTO === null) {
            $res->setCode("RSP_05");
            $res->setMessage("El correo no esta asociado a una cuenta");
            throw new Exception();
        }

        //Crea el token de confirmación de
        $recoverToken = "Bearer " . $tokenBusinessImpl->createRecoverToken($data->email,'Recover Password');

        //Envia email de confirmación
        try {
            $emailBusinessImpl->sendRecoverPassword($data->email, $userDTO->getUsername(), $recoverToken);
        } catch (Exception $th) {
            $res->setCode("RSP_08");
            $res->setMessage("Fallo en el envio de email");
            throw new Exception();
        }

        //Establece respuesta OK
        http_response_code(200);
        $res->setCode("RSP_00");
        $res->setMessage("Respuesta exitosa");

    } catch (Exception $e) {
        http_response_code(201);
    } finally {
        echo json_encode($res);
    }
}