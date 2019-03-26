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
        changePass();
        break;

    default:
        # code...
        break;
}

function changePass(){
    $res = new ResponseDTO();
    $userDTO = new UserDTO();
    $userBusinessImpl = new UserBusinessImpl();
    $tokenBusinessImpl = new TokenBusinessImpl();

    //Inputs de la peticion
    $data = json_decode(file_get_contents("php://input"));

    //Obtener el header de autorizacion
    $data = json_decode(file_get_contents("php://input"));
    $bearerToken = getallheaders()["Authorization"];
    $recoverToken = substr($bearerToken, 7);

    try {
        //Comprobar que el token de recuperacion no este vacio
        if (
            empty($recoverToken)
        ) {
            $res->setCode("RSP_??");
            $res->setMessage("Necesitas un token de session para actualizar la contraseña de usuario");
            throw new Exception("No tienes autorización");
        }

        //Validar token de recuperacion
        try {
            //Si el token es valido, la función retorna un objeto payload, de lo contrario lanza una excepción
            $tokenPayload = $tokenBusinessImpl->decodeRecoverToken($recoverToken);
        } catch (Exception $th) {
            $res->setCode("RSP_??");
            $res->setMessage("Token invalido. No tienes autorización");
            throw new Exception();
        }

        //Obtener el email de usuario desde el token de recuperacion
        $email = $tokenPayload->data->email;
        var_dump($email);

        //Busca usuario por email
        try {
            $userDTOtoChange = $userBusinessImpl->findByEmail($email);
        } catch (Exception $th) {
            $res->setCode("RSP_06");
            $res->setMessage("No fue posible verificar existencia por email");
            throw new Exception();
        }

        //Verifica si la busqueda por email regreso algun valor
        if ($userDTOtoChange === null) {
            $res->setCode("RSP_??");
            $res->setMessage("El correo no esta asociado a una cuenta");
            throw new Exception();
        }

        // Verifica que la contraseña no esté vacia
        
        if (empty($data->password)) {
            $res->setCode("RSP_02");
            $res->setMessage("Faltaron algunos datos");
            throw new Exception();
        }
        $hashedPassword = password_hash($data->password, PASSWORD_BCRYPT);
        $userDTOtoChange->setPassword($hashedPassword);

        //Actualizar usuario en base de datos
        try {
            $userBusinessImpl->update($userDTOtoChange);

        } catch (Exception $e) {
            $res->setCode("RSP_??");
            $res->setMessage("Error al persistir");
            throw new Exception();
        }
        http_response_code(200);
        $res->setCode("RSP_00");
        $res->setMessage("Respuesta exitosa");
        echo json_encode($res);

    } catch (Exception $e) {
        http_response_code(201);
        $res->setResponse($e->getMessage());
        echo json_encode($res);
    }
}