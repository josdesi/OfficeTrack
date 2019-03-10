<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';

include_once '../entity/User.php';
include_once '../entity/Session.php';

include_once '../dto/UserDTO.php';
include_once '../dto/SessionDTO.php';
include_once '../dto/ResponseDTO.php';

include_once '../business/UserBusiness.php';
include_once '../business/sessionBusiness.php';

include_once '../business/implementation/UserBusinessImpl.php';
include_once '../business/implementation/TokenBusinessImpl.php';
include_once '../business/implementation/sessionBusinessImpl.php';

require_once('../vendor/autoload.php');

$requestMethod = $_SERVER["REQUEST_METHOD"];

switch ($requestMethod) {
    case 'POST':
        login();
        break;

    default:
        # code...
        break;
}

function login()
{
    $res = new ResponseDTO();
    $userBusinessImpl = new UserBusinessImpl();
    $tokenBusinessImpl = new TokenBusinessImpl();
    $sessionBusinessImpl = new sessionBusinessImpl();
    $sessionDTO = new SessionDTO;
    $userDTO = new UserDTO;

    $data = json_decode(file_get_contents("php://input"));

    try {
        //Comprobar que la peticion sea correcta
        if
        (
            empty($data->username) ||
            empty($data->password) ||
            empty($data->sessionType) 
        ) {
            $res->setCode("RSP_??");
            $res->setMessage("Faltaron algunos datos");
            throw new Exception("Body Request Error");
        }

        //Recuperar usuario por nombre de usuario
        try {
            $userDTO = $userBusinessImpl->findUserByUsername($data->username);
        } catch (Exception $th) {
            $res->setCode("RSP_??");
            $res->setMessage("No fue posible comprobar la informacion");
            throw new Exception("");
        }

        //Comprobar que el usuario exista
        if ($userDTO === null) {
            $res->setCode("RSP_??");
            $res->setMessage("El usuario no exite");
            throw new Exception("");
        }

        //Comprobar que la contraseña sea la correcta
        if(!($userBusinessImpl->verifyPassword($data->username, $data->password))) {
            $res->setCode("RSP_??");
            $res->setMessage("Contraseña incorrecta");
            throw new Exception("");
        }

        //Eliminar sesiones anteriores
        try {
            $userId = $userDTO->getUserId();
            $sessionType = $data->sessionType;

            $sessionDTO->setUserId($userId);
            $sessionDTO->setSessionType($sessionType);

            $sessionBusinessImpl->deleteSession($sessionDTO);
        } catch (Exception $th) {
            $res->setCode("RSP_??");
            $res->setMessage("No fue posible cerrar sesión");
            throw new Exception();
        }

        //Generar el Bearer token
        try {
            $sessionType = $data->sessionType;

            $sessionToken = $tokenBusinessImpl->createSessionToken($userDTO, $sessionType);

            $BearerToken = "Bearer " . $sessionToken;

        } catch (Exception $th) {
            $res->setCode("RSP_??");
            $res->setMessage("No fue posible crear el token");
            throw new Exception();
        }

        //Persistir session en la tabla session
        try {
            $userId = $userDTO->getUserId();
            $sessionType = $data->sessionType;

            $sessionDTO->setToken($sessionToken);
            $sessionDTO->setUserId($userId);            
            $sessionDTO->setSessionType($sessionType);

            $sessionBusinessImpl->createSession($sessionDTO);

        } catch (Exception $th ) {
            $res->setCode("RSP_??");
            $res->setMessage("Error durante la persistencia");
            throw new Exception();
        }

        //Enviar Bearer Token por el header Authorization
        header("Authorization: $BearerToken");

        http_response_code(200);
        $res->setCode("RSP_00");
        $res->setMessage("Autorizado");
        echo json_encode($res);

    } catch (Exception $e) {
        http_response_code(201);
        $res->setResponse($e->getMessage());
        echo json_encode($res);
    }
}
