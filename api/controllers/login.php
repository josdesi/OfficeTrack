<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../entity/User.php';
include_once '../dto/UserDTO.php';
include_once '../config/database.php';
include_once '../entity/Room.php';
include_once '../dto/RoomDTO.php';
include_once '../dto/ResponseDTO.php';
include_once '../exception/ManagerException.php';
include_once '../business/UserBusiness.php';
include_once '../business/implementation/UserBusinessImpl.php';
include_once '../business/implementation/TokenBusinessImpl.php';



$requestMethod = $_SERVER["REQUEST_METHOD"];

switch ($requestMethod) {
    case 'POST':
        login();
        break;
    
    default:
        # code...
        break;
}

function login(){
    $res = new ResponseDTO();
    $userBusinessImpl = new UserBusinessImpl();
    $tokenBusinessImpl = new TokenBusinessImpl();

    $data = json_decode(file_get_contents("php://input"));
    
    try {

        $userDTO = $userBusinessImpl->findUserByUsername($data->username);

        if 
        (
            empty($data->username) ||
            empty($data->password)
        ) {
            $res->setCode("RSP_01");
            $res->setMessage("Faltaron algunos datos");
            throw new Exception("Body Request Error");
        }

        if
        (
            $userDTO === null ||
            !($userBusinessImpl->verifyPassword($data->username, $data->password))
        ){
            $res->setCode("RSP_??");
            $res->setMessage("Incorrect user or password");
            throw new Exception("");
        }

        $token = "Bearer " . $tokenBusinessImpl->createToken($userDTO);
        header("Auhtorization: $token");

        http_response_code(200);
        $res->setCode("RSP_00");
        $res->setMessage("Autorizado");
        $res->setResponse($token);
        echo json_encode($res);

    } catch (Exception $e) {
        http_response_code(201);
        $res->setResponse($e->getMessage());
        echo json_encode($res);
    }

}

?>