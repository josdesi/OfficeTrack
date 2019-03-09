<?php
    $userAct = $_POST['nombreUsuario'];
    $conec = getConnection();
    $resul = mysqli_query($conec, "SELECT id FROM 'users' WHERE username =  '$userAct'");
    $deleteConec = "DELETE FROM 'sessions' WHERE userID = '$resul'";
    mysqli_query($conec,$deleteConec);
    mysqli_close($conec);
?>

<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../entity/User.php';
include_once '../entity/Session.php';
include_once '../dto/SessionDTO.php';
include_once '../config/database.php';
include_once '../entity/Room.php';
include_once '../dto/RoomDTO.php';
include_once '../dto/ResponseDTO.php';
include_once '../exception/ManagerException.php';
include_once '../business/UserBusiness.php';
include_once '../business/SessionBusiness.php';
include_once '../business/implementation/UserBusinessImpl.php';
include_once '../business/implementation/SessionBusinessImpl.php';
include_once '../business/implementation/TokenBusinessImpl.php';

$requestMethod = $_SERVER["REQUEST_METHOD"];

switch ($requestMethod) {
    case 'POST':
        logout();
        break;
    
    default:
        break;
}

function logout(){
	$res = new ResponseDTO();
    $userBusiness = new UserBusinessImpl();
    $SessionBusiness = new SessionBusinessImpl();
    $SessionDTO = new SessionDTO();

    $data = json_decode(file_get_contents("php://input"));
     try {

        if ( empty($data->username) ) {
            $res->setCode("RSP_01");
            $res->setResponse("Faltaron algunos datos");
            throw new Exception("Body Request Error");
        }

        if ($userBusiness->findUserByUsername($data->username) === null) {
            $res->setCode("RSP_03");
            $res->setResponse("El usuario no existente");
            throw new Exception("");
        }

        $SessionDTO->setUserId($data->id);
        $SessionBusiness->deleteSession($sessionDTO);

    } catch (Exception $e) {
    }

}

?>