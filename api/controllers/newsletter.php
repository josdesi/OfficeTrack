<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../entity/Newsletter.php';
include_once '../dto/NewsletterDTO.php';
include_once '../config/database.php';
include_once '../dto/ResponseDTO.php';
include_once '../exception/ManagerException.php';
include_once '../business/NewsletterBusiness.php';
include_once '../business/implementation/NewsletterBusinessImpl.php';
include_once '../business/implementation/EmailBusinessImpl.php';

require '../libs/PHPMailer/Exception.php';
require '../libs/PHPMailer/PHPMailer.php';
require '../libs/PHPMailer/SMTP.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'POST':
        createNewsletter();
        break;

    default:
        # code...
        break;
}

function createNewsletter()
{

    $res = new ResponseDTO();
    $newsletterDTO = new NewsletterDTO();
    $emailBusiness = new EmailBusinessImpl();
    $newsletterBusiness = new NewsletterBusinessImpl();

    $data = json_decode(file_get_contents("php://input"));

    try {

        if(empty($data->email)){
            $res->setCode("RSP_01");
            $res->setMessage("Faltaron datos");
            throw new Exception();
        }

        try {
            $emailExist = $newsletterBusiness->findByEmail($data->email) === null ? false : true;
        } catch (Exception $th) {
            $res->setCode("RSP_06");
            $res->setMessage("No fue posible verificar datos");
            throw new Exception();
        }

        if ($emailExist) {
            $res->setCode("RSP_02");
            $res->setMessage("El correo ya se encuentra registrado");
            throw new Exception();
        }

        try {
            $newsletterDTO->setEmail($data->email);
            $newsletterBusiness->createNewsletter($newsletterDTO);
        } catch (Exception $e) {
            $res->setCode("RSP_??");
            $res->setMessage("Error al persistir");
            throw new Exception();            
        }

        try {
            $emailBusiness->sendNewsletterConfirmation($data->email);
        } catch (Exception $th) {
            $res->setCode("RSP_05");
            $res->setMessage("Fallo en el envio de email");
            throw new Exception();
        }

        http_response_code(200);
        $res->setCode("RSP_00");
        $res->setMessage("Respuesta exitosa");
        $res->setResponse("");

    } catch (Exception $e) {
        http_response_code(201);
    } finally {
        echo json_encode($res);
    }

}
