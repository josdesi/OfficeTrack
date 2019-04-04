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
include_once '../entity/User.php';

//DTO's
include_once '../dto/UserDTO.php';
include_once '../dto/ResponseDTO.php';

//Interfaces de businesses
include_once '../business/UserBusiness.php';

//Businesses
include_once '../business/implementation/UserBusinessImpl.php';
include_once '../business/implementation/TokenBusinessImpl.php';
include_once '../business/implementation/EmailBusinessImpl.php';

//Librerias desde composer
require_once '../vendor/autoload.php';

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
    $userBusinessImpl = new UserBusinessImpl();
    $emailBusinessImpl = new EmailBusinessImpl();
    $userDTO = new UserDTO();

    //Inputs de la peticion
    $data = json_decode(file_get_contents("php://input"));

    try {

        //Confirma que la petición es correcta
        if (
            empty($data->username) ||
            empty($data->email) ||
            empty($data->password)
        ) {
            $res->setCode("RSP_01");
            $res->setMessage("Faltaron datos");
            throw new Exception();
        }

        //Busca usuario por userName
        try {
            $userDTO = $userBusinessImpl->findByUsername($data->username);
        } catch (Exception $th) {
            
            $res->setCode("RSP_03");
            $res->setMessage("No fue posible verificar existencia por userName");
            throw new Exception();
        }

        //Verifica si la busqueda por userName regreso algun valor
        if ($userDTO !== null) {
            $res->setCode("RSP_06");
            $res->setMessage("El nombre de usuario ya esta en uso");
            throw new Exception();
        }

        //Busca usuario por email
        try {
            $userDTO = $userBusinessImpl->findByEmail($data->email);
        } catch (Exception $th) {
            $res->setCode("RSP_03");
            $res->setMessage("No fue posible verificar existencia por email");
            throw new Exception();
        }

        //Verifica si la busqueda por email regreso algun valor
        if ($userDTO !== null) {
            $res->setCode("RSP_05");
            $res->setMessage("El correo ya esta osociado a una cuenta");
            throw new Exception();
        }

        //Crea el token de confirmación de cuenta
        $userAndDate = date("c") . $data->username;
        $emailToken = md5($userAndDate);
        $confirmationLink = "http://localhost/api/controllers/confirm.php?token=$emailToken";

        //Crea usuario en base de datos
        try {
            // Ciframos el password para no tener acceso a el en la base de datos
            $hashedPassword = password_hash($data->password, PASSWORD_BCRYPT);

            $userDTO = new UserDTO();
            $userDTO->setUsername($data->username);
            $userDTO->setPassword($hashedPassword); //El password sera cifrado con la función password_hash()
            $userDTO->setEmail($data->email);
            $userDTO->setEmailToken($emailToken);

            $userBusinessImpl->create($userDTO);

        } catch (Exception $e) {
            $res->setCode("RSP_07");
            $res->setMessage("Error al persistir");
            throw new Exception();
        }

        //Envia email de confirmación
        try {
            $emailBusinessImpl->sendRegistryConfirmation($data->email, $data->username, $confirmationLink);
        } catch (Exception $th) {
            $res->setCode("RSP_08");
            $res->setMessage("Fallo en el envio de email");
            throw new Exception();
        }

        //Establece respuesta OK
        http_response_code(200);
        $res->setCode("RSP_00");
        $res->setMessage("Respuesta exitosa");

    } catch (Exception $e) {
        http_response_code(201);
    } finally {
        echo json_encode($res);
    }
}

function updateUser()
{

    $res = new ResponseDTO();
    $userDTO = new UserDTO();
    $userBusinessImpl = new UserBusinessImpl();
    $tokenBusinessImpl = new TokenBusinessImpl();

    //Inputs de la peticion
    $data = json_decode(file_get_contents("php://input"));

    //Obtener el header de autorizacion
    $data = json_decode(file_get_contents("php://input"));
    $bearerToken = getallheaders()["Authorization"];
    $sessionToken = substr($bearerToken, 7);

    try {
        //Comprobar que el token de sesión no este vacio
        if (
            empty($sessionToken)
        ) {
            $res->setCode("RSP_??");
            $res->setMessage("Necesitas un token de session para eliminar un usuario");
            throw new Exception("No tienes autorización");
        }

        //Validar token de sesión
        try {
            //Si el token es valido, la función retorna un objeto payload, de lo contrario lanza una excepción
            $tokenPayload = $tokenBusinessImpl->decodeSessionToken($sessionToken);
        } catch (Exception $th) {
            $res->setCode("RSP_??");
            $res->setMessage("Token invalido. No tienes autorización");
            throw new Exception();
        }

        //Obtener el id de usuario desde el token de sesión
        $userId = $tokenPayload->data->userId;

        //Busca usuario por userId
        try {
            $userDTOtoChange = $userBusinessImpl->findByUserId($userId);
        } catch (Exception $th) {
            $res->setCode("RSP_06");
            $res->setMessage("No fue posible verificar existencia por userId");
            throw new Exception();
        }

        //Verifica si la busqueda por userId regreso algun valor
        if ($userDTOtoChange === null) {
            $res->setCode("RSP_02");
            $res->setMessage("No existe ningun usuario con ese id");
            throw new Exception();
        }

        //Si se quiere cambiar el userName
        if (!empty($data->username)) {

            //Busca usuario por userName
            try {
                $userDTO = $userBusinessImpl->findByUsername($data->username);
            } catch (Exception $th) {
                $res->setCode("RSP_06");
                $res->setMessage("No fue posible verificar existencia por username");
                throw new Exception();
            }

            //Verifica si la busqueda por userName regreso algun valor
            if ($userDTO !== null) {
                $res->setCode("RSP_02");
                $res->setMessage("El nombre de usuario ya esta en uso");
                throw new Exception();
            }

            $userDTOtoChange->setUsername($data->username);

        }

        //Si se quiere cambiar la contraseña
        if(!empty($data->newPassword)){
            if (empty($data->password)) {
                $res->setCode("RSP_02");
                $res->setMessage("Para ingresar una nueva contraseña debe ingresar la contraseña actual");
                throw new Exception();
            }
            if ($data->password == $data->newPassword) {
                $res->setCode("RSP_02");
                $res->setMessage("Las contraseñas deben ser diferentes");
                throw new Exception();
            }
            //Verificar que la contraseña sea correcta
            $passwordFormDB = $userDTOtoChange->getPassword();
            $passwordIsCorrect = $userBusinessImpl->verifyPassword($passwordFormDB, $data->password);
            if($passwordIsCorrect){
                $userDTOtoChange->setPassword($data->password);
            }
        }

        //Si se quiere cambiar el nombre
        if(!empty($data->name)){
            $userDTOtoChange->setName($data->name);
        }

        //Si se quiere cambiar el fatherSurname
        if(!empty($data->fatherSurname)){
            $userDTOtoChange->setFatherSurname($data->fatherSurname);
        }

        //Si se quiere cambiar el motherSurname
        if(!empty($data->motherSurname)){
            $userDTOtoChange->setMotherSurname($data->motherSurname);
        }

        //Si se quiere cambiar el numero de telefono
        if(!empty($data->phone)){
            $userDTOtoChange->setPhone($data->phone);
        }

        //Si se quiere cambiar el email
        if (!empty($data->email)) {

            //Busca usuario por email
            try {
                $userDTO = $userBusinessImpl->findByEmail($data->email);
            } catch (Exception $th) {
                $res->setCode("RSP_06");
                $res->setMessage("No fue posible verificar existencia por email");
                throw new Exception();
            }

            //Verifica si la busqueda por email regreso algun valor
            if ($userDTO !== null) {
                $res->setCode("RSP_02");
                $res->setMessage("Ya existe una cuenta asociada a este correo");
                throw new Exception();
            }

            $userDTOtoChange->setEmail($data->email);
        }

        //Actualizar usuario en base de datos
        try {
            $userBusinessImpl->update($userDTOtoChange);

        } catch (Exception $e) {
            $res->setCode("RSP_??");
            $res->setMessage("Error al persistir");
            throw new Exception();
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
    $userDTO = new UserDTO();
    $userBusinessImpl = new UserBusinessImpl();
    $tokenBusinessImpl = new TokenBusinessImpl();

    //Inputs de la peticion
    $data = json_decode(file_get_contents("php://input"));

    //Obtener el header de autorizacion
    $data = json_decode(file_get_contents("php://input"));
    $bearerToken = getallheaders()["Authorization"];
    $sessionToken = substr($bearerToken, 7);

    try {
        //Comprobar que el token de sesión no este vacio
        if (
            empty($sessionToken)
        ) {
            $res->setCode("RSP_??");
            $res->setMessage("Necesitas un token de session para eliminar un usuario");
            throw new Exception("No tienes autorización");
        }

        //Validar token de sesión
        try {
            //Si el token es valido, la función retorna un objeto payload, de lo contrario lanza una excepción
            $tokenPayload = $tokenBusinessImpl->decodeSessionToken($sessionToken);
        } catch (Exception $th) {
            $res->setCode("RSP_??");
            $res->setMessage("Token invalido. No tienes autorización");
            throw new Exception();
        }

        //Obtener el id de usuario desde el token de sesión
        $userId = $tokenPayload->data->userId;

        //Busca usuario por id
        try {
            $userDTO = $userBusinessImpl->findByUserId($userId);
        } catch (Exception $th) {
            $res->setCode("RSP_06");
            $res->setMessage("No fue posible verificar existencia por userId");
            throw new Exception();
        }

        //Verifica si la busqueda por userId regreso algun valor
        if ($userDTO === null) {
            $res->setCode("RSP_02");
            $res->setMessage("No existe ninguna usuario con este id");
            throw new Exception();
        }

        //Elimina el usuario de la tabla users
        try {
            $userBusinessImpl->delete($userDTO);
        } catch (Exception $th) {
            $res->setCode("RSP_?2");
            $res->setMessage("No fue posible eliminar el registro de la tabla users");            
            throw new Exception("");
        }

        //Establecer respuesta OK
        http_response_code(200);
        $res->setCode("RSP_00");
        $res->setMessage("El usuario se elimino exitosamente");
    } catch (Exception $th) {

    } finally {
        //Enviar respuesta
        echo json_encode($res);
    }
}
