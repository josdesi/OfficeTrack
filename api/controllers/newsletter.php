<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Conexión a la base de datos
include_once '../config/database.php';

//Entidades
include_once '../entity/Newsletter.php';

//DTO's
include_once '../dto/NewsletterDTO.php';
include_once '../dto/ResponseDTO.php';

//Interfaces de businesses
include_once '../business/NewsletterBusiness.php';

//Businesses
include_once '../business/implementation/NewsletterBusinessImpl.php';
include_once '../business/implementation/EmailBusinessImpl.php';

//Librerias desde Composer
require_once '../vendor/autoload.php';

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
    $emailBusiness = new EmailBusinessImpl();
    $NewsletterBusinessImpl = new NewsletterBusinessImpl();

    $data = json_decode(file_get_contents("php://input"));

    try {

        //Confirma que la petición es correcta
        if (empty($data->email)) {
            $res->setCode("RSP_01");
            $res->setMessage("Faltaron datos");
            throw new Exception();
        }

        //Busca newsletter por email
        try {
            $newsletterDTO = $NewsletterBusinessImpl->findByEmail($data->email);
        } catch (Exception $th) {
            $res->setCode("RSP_06");
            $res->setMessage("No fue posible verificar datos");
            throw new Exception();
        }

        //Verifica si la busqueda por email regreso algun valor
        if ($newsletterDTO !== null) {
            $res->setCode("RSP_02");
            $res->setMessage("El correo ya se encuentra registrado");
            throw new Exception();
        }

        //Crea un token
        $userAndDate = date("c") . $data->email;
        $newsletterToken = md5($userAndDate);

        //Crea newsletter en base de datos
        try {
            
            $newsletterDTO = new NewsletterDTO();
            $newsletterDTO->setEmail($data->email);
            $newsletterDTO->setNewsletterToken($newsletterToken);

            $NewsletterBusinessImpl->create($newsletterDTO);
            
        } catch (Exception $e) {
            $res->setCode("RSP_??");
            $res->setMessage("Error al persistir");
            throw new Exception();
        }

        //Envia email de confirmación
        try {
            $emailBusiness->sendNewsletterConfirmation($data->email, $newsletterToken);
        } catch (Exception $th) {
            $res->setCode("RSP_05");
            $res->setMessage("Fallo en el envio de email");
            throw new Exception();
        }

        //Envia respuesta OK
        http_response_code(200);
        $res->setCode("RSP_00");
        $res->setMessage("Respuesta exitosa");

    } catch (Exception $e) {
        http_response_code(201);
    } finally {
        echo json_encode($res);
    }
}
