<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../entity/User.php';
include_once '../dto/UserDTO.php';
include_once '../dto/ResponseDTO.php';
include_once '../exception/ManagerException.php';
include_once '../business/UserBusiness.php';
include_once '../business/implementation/UserBusinessImpl.php';
include_once '../business/implementation/TokenBusinessImpl.php';
include_once '../business/implementation/EmailBusinessImpl.php';



require '../libs/PHPMailer/Exception.php';
require '../libs/PHPMailer/PHPMailer.php';
require '../libs/PHPMailer/SMTP.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'POST':
        createUser();
        break;

    case 'PUT':
        updateUser();
        break;

    case 'DELETE':
        deleteUser();
        break;

    default:
        # code...
        break;

}

function createUser()
{

    $res = new ResponseDTO();
    $userBusiness = new UserBusinessImpl();
    $emailBusiness = new EmailBusinessImpl();
    $userDTO = new UserDTO();

    $data = json_decode(file_get_contents("php://input"));

    try {

        if (
            empty($data->username) ||
            empty($data->email) ||
            empty($data->password)
        ) {
            $res->setCode("RSP_01");
            $res->setResponse("Faltaron algunos datos");
            throw new Exception("Body Request Error");
        } 

        if($userBusiness->findUserByEmail($data->email) !== null){
            $res->setCode("RSP_02");
            $res->setResponse("Email existente");
            throw new Exception("");
        }

        if($userBusiness->findUserByUsername($data->username) !== null){
            $res->setCode("RSP_03");
            $res->setResponse("Useario existente");
            throw new Exception("");
        }

        $userAndDate = date("c") . $data->username;
        $emailToken = md5($userAndDate);

        $userDTO->setUsername($data->username);
        $userDTO->setPassword($data->password);
        $userDTO->setEmail($data->email);
        $userDTO->setEmailToken($emailToken);

        $userBusiness->createUser($userDTO);

        $confirmLink = "http://confirm/$emailToken";

        $emailBusiness->sendConfirmEmail($data->email, "<a href=$confirmLink>Da click aqui para confirmar tu cuenta</a>");

        http_response_code(200);
        $res->setCode("RSP_00");
        $res->setMessage("Respuesta exitosa");
        $res->setResponse("");
        echo json_encode($res);

    } catch (Exception $e) {
        http_response_code(201);
        $res->setResponse($e->getMessage());
        echo json_encode($res);
    }
}

function updateUser()
{

    $res = new ResponseDTO();
    $userDTO = new UserDTO();
    $userBusiness = new UserBusinessImpl();
    $tokenBusinessImpl = new TokenBusinessImpl();

    $data = json_decode(file_get_contents("php://input"));

    try {

        if($userBusiness->findUserByEmail($userIdentity["email"]) === null){
            $res->setCode("RSP_02");
            $res->setMessage("Email no existente");
            throw new Exception("");
        }

        if($userBusiness->findUserByUsername($userIdentity["username"]) === null){
            $res->setCode("RSP_03");
            $res->setMessage("Useario no existente");
            throw new Exception("");
        }

        $userDTO->setId($data->id);
        $userDTO->setUsername($data->username);
        $userDTO->setPassword($data->password);
        $userDTO->setName($data->name);
        $userDTO->setFatherSurname($data->fatherSurname);
        $userDTO->setMotherSurname($data->motherSurname);
        $userDTO->setPhone($data->phone);
        $userDTO->setEmail($data->email);

        if ($userBusiness->updateUser($userDTO)) {
            $token = $tokenBusinessImpl->createToken($userDTO);
            $res->setResponse($token);
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

function deleteUser()
{

    $res = new ResponseDTO();
    $userBusiness = new UserBusinessImpl();
    $userDTO = new UserDTO();

    $data = json_decode(file_get_contents("php://input"));

    try {

        if (
            empty($data->username)
        ) {
            $res->setCode("RSP_01");
            $res->setResponse("Faltaron algunos datos");
            throw new Exception("Body Request Error");
        }

        if($userBusiness->findUserByUsername($data->username) === null){
            $res->setCode("RSP_03");
            $res->setResponse("El usuario no existente");
            throw new Exception("");
        }

        $userDTO->setUsername($data->username);

        $userBusiness->deleteUser($userDTO);

        http_response_code(200);
        $res->setCode("RSP_00");
        $res->setMessage("Respuesta exitosa");
        $res->setResponse("");
        echo json_encode($res);

    } catch (Exception $e) {
        http_response_code(201);
        $res->setResponse($e->getMessage());
        echo json_encode($res);
    }

}
