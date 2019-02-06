<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare product object
$user = new User($db);

$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        // make sure data is not empty
        if (
            !empty($data->username) &&
            !empty($data->email) &&
            !empty($data->password)
        ) {

            // set user property values
            $user->username = $data->username;
            $user->password = $data->password;
            $user->email = $data->email;

            // create the user
            if ($user->create()) {

                // set response code - 201 created
                http_response_code(201);

                // tell the user
                echo json_encode(array("message" => "Usuario agregado exitosamente."));
            }

            // if unable to create the user, tell the user
            else {

                // set response code - 503 service unavailable
                http_response_code(503);

                // tell the user
                echo json_encode(array("message" => "El usuario no pudo crearse."));
            }
        }

        // tell the user data is incomplete
        else {

            // set response code - 400 bad request
            http_response_code(400);

            // tell the user
            echo json_encode(array("message" => "Faltaron algunos datos."));
        }
        break;

    case 'PUT':
        // get id of user to be edited
        $data = json_decode(file_get_contents("php://input"));

        // set ID property of user to be edited
        $user->id = $data->id;

        // set user property values
        $user->name = $data->name;
        $user->fatherSurname = $data->fatherSurname;
        $user->motherSurname = $data->motherSurname;
        $user->phone = $data->phone;

        // update the user
        if ($user->update()) {

            // set response code - 200 ok
            http_response_code(200);

            // tell the user
            echo json_encode(array("message" => "El usuario se actualizo correctamente."));
        }

        // if unable to update the user, tell the user
        else {

            // set response code - 503 service unavailable
            http_response_code(503);

            // tell the user
            echo json_encode(array("message" => "No se ha podido actualizar el usuario."));
        }
        break;

    default:
        # code...
        break;
}
