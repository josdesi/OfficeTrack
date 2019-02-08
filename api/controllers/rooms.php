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
include_once '../entity/Room.php';
include_once '../dto/RoomDTO.php';
include_once '../dto/ResponseDTO.php';
include_once '../exception/ManagerException.php';
include_once '../business/RoomBusiness.php';
include_once '../business/implementation/RoomBusinessImpl.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'POST':
        createRoom();
        break;

    case 'PUT':
        # code...
        break;

    default:
        # code...
        break;

}

function createRoom()
{

    $res = new ResponseDTO();

    try {
        $data = json_decode(file_get_contents("php://input"));

        if (
            empty($data->roomName) ||
            empty($data->roomKey) ||
            empty($data->typeRoomId)
        ) {
            $res->setCode("RSP_01");
            $res->setMessage("Faltaron algunos datos");
            throw new Exception("Body Request Error");
        } 

        $roomDTO = new RoomDTO();
        $roomDTO->setRoomName($data->roomName);
        $roomDTO->setRoomKey($data->roomKey);
        $roomDTO->setTypeRoomId($data->typeRoomId);
        $roomBusiness = new RoomBusinessImpl();
        $roomBusiness->createRoom($roomDTO);

        http_response_code(200);
        $res->setCode("RSP_00");
        $res->setMessage("Respuesta exitosa");
        $res->setResponse("");
        echo json_encode($res);

    } catch (Exception $e) {
        http_response_code(201);
        $res->setMessage($e->getMessage());
        $res->setCode($e->getErrorCode());
        echo json_encode($res);
    }

}
