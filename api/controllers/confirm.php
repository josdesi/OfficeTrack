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
    case 'GET':
        confirmEmailToken();
        break;

    default:
        # code...
        break;

}

function confirmEmailToken()
{
    $res = new ResponseDTO();
    $userBusiness = new UserBusinessImpl();
    $emailBusiness = new EmailBusinessImpl();
    $userDTO = new UserDTO();

    $emailToken = $_GET['token'];
    $confirmEmailToken = $userBusiness->confirmEmailToken($emailToken);

    if (isset($emailToken)) {
        if ($confirmEmailToken !== null) {
            header("Location: http://localhost/web/login.html");
            die();
        }

    } else {
        $res->setCode("RSP_??");
        $res->setResponse("token no valido");
        echo json_encode($res);
    }

}
