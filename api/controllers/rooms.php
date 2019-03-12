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
include_once '../entity/Room.php';

//DTO's
include_once '../dto/RoomDTO.php';
include_once '../dto/ResponseDTO.php';

//Interfaces de businesses
include_once '../business/RoomBusiness.php';

//Businesses
include_once '../business/implementation/RoomBusinessImpl.php';
include_once '../business/implementation/TokenBusinessImpl.php';

//Librerias desde composer
require_once '../vendor/autoload.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'POST':
        createRoom();
        break;

    case 'PUT':
        # code...
        break;

    case 'DELETE':
        deleteRoom();
        break;

    default:
        # code...
        break;

}

function createRoom()
{

    $res = new ResponseDTO();
    $roomDTO = new RoomDTO();
    $roomBusinessImpl = new RoomBusinessImpl();
    $tokenBusinessImpl = new TokenBusinessImpl();

    //Inputs de la peticion
    $data = json_decode(file_get_contents("php://input"));

    //Obtener el header de autorizacion
    $data = json_decode(file_get_contents("php://input"));
    $bearerToken = getallheaders()["Authorization"];
    $sessionToken = substr($bearerToken, 7);

    try {
        //Comprobar el header de autorización no este vacio
        if (
            empty($sessionToken)
        ) {
            $res->setCode("RSP_??");
            $res->setMessage("Necesitas un token de session para crear un habitación");
            throw new Exception("No tienes autorización");
        }

        //Validar token de autorizacion
        try {
            //Si el token es valido, la función retorna el payload, de lo contrario lanza una excepción
            $tokenPayload = $tokenBusinessImpl->decodeSessionToken($sessionToken);
        } catch (Exception $th) {
            $res->setCode("RSP_??");
            $res->setMessage("Token invalido. No tienes autorización");
            throw new Exception();
        }

        //Confirma que la petición es correcta
        if (
            empty($data->roomName) ||
            empty($data->roomKey) ||
            empty($data->roomTypeId)
        ) {
            $res->setCode("RSP_01");
            $res->setMessage("Faltaron algunos datos");
            throw new Exception("Body Request Error");
        }

        //Busca room por roomName
        try {
            $roomDTO = $roomBusinessImpl->findByRoomName($data->roomName);
        } catch (Exception $th) {
            $res->setCode("RSP_06");
            $res->setMessage("No fue posible verificar existencia por roomName");
            throw new Exception();
        }

        //Verifica si la busqueda por roomName regreso algun valor
        if ($roomDTO !== null) {
            $res->setCode("RSP_02");
            $res->setMessage("Ya existe una habitacion con el mismo nombre");
            throw new Exception();
        }

        //Busca room por roomKey
        try {
            $roomDTO = $roomBusinessImpl->findByRoomKey($data->roomKey);
        } catch (Exception $th) {
            $res->setCode("RSP_06");
            $res->setMessage("No fue posible verificar existencia por roomKey");
            throw new Exception();
        }

        //Verifica si la busqueda por roomKey regreso algun valor
        if ($roomDTO !== null) {
            $res->setCode("RSP_02");
            $res->setMessage("Ya existe una habitacion con el mismo roomKey");
            throw new Exception();
        }

        //Crea room en base de datos
        try {

            $roomDTO = new RoomDTO();
            $roomDTO->setRoomName($data->roomName);
            $roomDTO->setRoomKey($data->roomKey);
            $roomDTO->setRoomTypeId($data->roomTypeId);

            $roomBusinessImpl->create($roomDTO);

        } catch (Exception $e) {
            $res->setCode("RSP_??");
            $res->setMessage("Error al persistir");
            throw new Exception();
        }

        //Establecer respuesta OK
        http_response_code(200);
        $res->setCode("RSP_00");
        $res->setMessage("Respuesta exitosa");

    } catch (Exception $e) {
        http_response_code(201);
    } finally {
        //Enviar respuesta
        echo json_encode($res);
    }
}

function deleteRoom()
{

    $res = new ResponseDTO();
    $roomDTO = new RoomDTO();
    $roomBusinessImpl = new RoomBusinessImpl();
    $tokenBusinessImpl = new TokenBusinessImpl();

    //Inputs de la peticion
    $data = json_decode(file_get_contents("php://input"));

    //Obtener el header de autorizacion
    $data = json_decode(file_get_contents("php://input"));
    $bearerToken = getallheaders()["Authorization"];
    $sessionToken = substr($bearerToken, 7);

    try {
        //Comprobar el header de autorización no este vacio
        if (
            empty($sessionToken)
        ) {
            $res->setCode("RSP_??");
            $res->setMessage("Necesitas un token de session para crear un habitación");
            throw new Exception("No tienes autorización");
        }

        //Validar token de autorizacion
        try {
            //Si el token es valido, la función retorna el payload, de lo contrario lanza una excepción
            $tokenPayload = $tokenBusinessImpl->decodeSessionToken($sessionToken);
        } catch (Exception $th) {
            $res->setCode("RSP_??");
            $res->setMessage("Token invalido. No tienes autorización");
            throw new Exception();
        }

        //Confirma que la petición es correcta
        if (
            empty($data->roomKey)
        ) {
            $res->setCode("RSP_01");
            $res->setResponse("Faltaron algunos datos");
            throw new Exception("Body Request Error");
        }

        //Busca room por roomKey
        try {
            $roomDTO = $roomBusinessImpl->findByRoomKey($data->roomKey);
        } catch (Exception $th) {
            $res->setCode("RSP_06");
            $res->setMessage("No fue posible verificar existencia por roomKey");
            throw new Exception();
        }

        //Verifica si la busqueda por roomKey regreso algun valor
        if ($roomDTO === null) {
            $res->setCode("RSP_02");
            $res->setMessage("No existe ninguna habitacion con este roomKey");
            throw new Exception();
        }

        //Elimina el room de la tabla newsletter
        try {
            $roomBusinessImpl->delete($roomDTO);
        } catch (Exception $th) {
            echo $th;
            $res->setCode("RSP_?2");
            $res->setResponse("No fue posible eliminar el registro de la tabla rooms");            
            throw new Exception("");
        }

        //Establecer respuesta OK
        http_response_code(200);
        $res->setCode("RSP_00");
        $res->setResponse("La habitación se elimino exitosamente");
    } catch (Exception $th) {

    } finally {
        //Enviar respuesta
        echo json_encode($res);
    }
}
