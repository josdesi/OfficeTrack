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

//Entidades
include_once '../entity/Newsletter.php';

//DTO's
include_once '../dto/NewsletterDTO.php';
include_once '../dto/ResponseDTO.php';

//Interfaces de businesses
include_once '../business/NewsletterBusiness.php';

//Businesses
include_once '../business/implementation/TokenBusinessImpl.php';
include_once '../business/implementation/NewsletterBusinessImpl.php';
include_once '../business/implementation/EmailBusinessImpl.php';

//Librerias de composer
require_once '../vendor/autoload.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'GET':
        confirmNewsletter();
        break;

    default:
        # code...
        break;
}

function confirmNewsletter()
{
    $res = new ResponseDTO();

    $status = filter_var($_GET['confirm'], FILTER_VALIDATE_BOOLEAN);
    $newsletterToken = $_GET['token'];

    if
    (
        !isset($status) ||
        !isset($newsletterToken)
    ) {
        $res->setCode("RSP_??");
        $res->setResponse("La peticion no esta completa");
        echo json_encode($res);
    } else {
        $status ? updateNewsletter() : deleteNewsletter();
    }
}

function updateNewsletter()
{
    $res = new ResponseDTO();
    $newsletterBusinessImpl = new NewsletterBusinessImpl();
    $newsletterDTO = new NewsletterDTO();

    $newsletterToken = $_GET['token'];

    try {
        //Buscar newsletter por token
        try {
            $newsletterDTO = $newsletterBusinessImpl->findByNewsletterToken($newsletterToken);
        } catch (Exception $th) {
            $res->setCode("RSP_06");
            $res->setMessage("No fue posible verificar datos");
            throw new Exception();
        }

        //Verifica si la busqueda por token regresa algun valor
        if ($newsletterDTO === null) {
            $res->setCode("RSP_?1");
            $res->setResponse("token no valido");
            throw new Exception("Token no valido");
        }

        //Cambiar el status de la subscripción en la base de datos
        try {
            $newsletterDTO->setStatus(true);
            $newsletterBusinessImpl->update($newsletterDTO);
        } catch (Exception $th) {
            $res->setCode("RSP_?1");
            $res->setResponse("No fue posible cambiar el status de la subscriptción");
            throw new Exception("Token no valido");
        }

        $res->setCode("RSP_00");
        $res->setResponse("La subscripción se completo exitosamente");
        header("Location: http://localhost/web/modal/m-06/modal.html");
    } catch (Exception $th) {

    } finally {
        echo json_encode($res);
    }
}

function deleteNewsletter()
{
    $res = new ResponseDTO();
    $newsletterBusinessImpl = new NewsletterBusinessImpl();
    $newsletterDTO = new NewsletterDTO();

    $newsletterToken = $_GET['token'];

    try {
        //Buscar newsletter por token
        try {
            $newsletterDTO = $newsletterBusinessImpl->findByNewsletterToken($newsletterToken);
        } catch (Exception $th) {
            $res->setCode("RSP_06");
            $res->setMessage("No fue posible verificar datos");
            throw new Exception();
        }

        //Verifica si la busqueda por token regresa algun valor
        if ($newsletterDTO === null) {
            $res->setCode("RSP_?2");
            $res->setResponse("El correo no se encuentra registrado en nuestro newsletter");
            throw new Exception("");
        }

        //Elimina el correo de la tabla newsletter
        try {
            $newsletterBusinessImpl->delete($newsletterDTO);
        } catch (Exception $th) {
            $res->setCode("RSP_?2");
            $res->setResponse("No fue posible eliminar el correo de nuestro newsletter");
            throw new Exception("");
        }

        $res->setCode("RSP_00");
        $res->setResponse("Se elimino el correo de nuestro newsletter");
        header("Location: http://localhost/web/modal/m-07/modal.html");
    } catch (Exception $th) {
        echo json_encode($res);
    } 
}
