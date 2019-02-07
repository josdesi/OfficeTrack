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

$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'POST':
        createUser();
        break;

    case 'PUT':
        updateUser();
        break;

    default:
        # code...
        break;

}

function createUser()
{

    $res = new ResponseDTO();

    try {
        $data = json_decode(file_get_contents("php://input"));

        if (
            empty($data->username) ||
            empty($data->email) ||
            empty($data->password)
        ) {
            $res->setCode("RSP_01");
            $res->setMessage("Faltaron algunos datos");
            throw new Exception("Body Request Error");
        } 

        $userDTO = new UserDTO();
        $userDTO->setUsername($data->username);
        $userDTO->setPassword($data->password);
        $userDTO->setEmail($data->email);
        $userBusiness = new UserBusinessImpl();
        $userBusiness->createUser($userDTO);

        http_response_code(200);
        $res->setCode("RSP_00");
        $res->setMessage("Respuesta exitosa");
        $res->setResponse("");
        echo json_encode($res);

    } catch (Exception $e) {
        http_response_code(201);
        $res->setMessaage($e->getMessage());
        $res->setCode($e->getCode());
        echo json_encode($res);
    }

}

function updateUser()
{

    $res = new ResponseDTO();

    try {
        $data = json_decode(file_get_contents("php://input"));

        $userDTO = new UserDTO();
        $userDTO->setId($data->id);
        $userDTO->setUsername($data->username);
        $userDTO->setPassword($data->password);
        $userDTO->setName($data->name);
        $userDTO->setFatherSurname($data->fatherSurname);
        $userDTO->setMotherSurname($data->motherSurname);
        $userDTO->setPhone($data->phone);
        $userDTO->setEmail($data->email);
        $userBusiness = new UserBusinessImpl();
        $userBusiness->updateUser($userDTO);

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
