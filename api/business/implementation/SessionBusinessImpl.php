<?php

class SessionBusinessImpl implements SessionBusiness
{

    public function create($sessionDTO)
    {
        try
        {
            //Conecta a la base de datos
            $database = new Database();
            $db = $database->getConnection();

            //Crea una entidad Session y pasa la conexión a la base de dastos
            $session = new Session($db);

            //Obtener los valores desde el SessionDTO que se pasa como parametro
            $userId = $sessionDTO->getUserId();
            $sessionToken = $sessionDTO->getSessionToken();
            $sessionType = $sessionDTO->getSessionType();

            //Establece valores de la entidad Session
            $session->userId = $userId;
            $session->sessionToken = $sessionToken;
            $session->sessionType = $sessionType;

            //Crea una fila en la tabla sessions basado en los valores de la entidad
            $session->create();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete($sessionDTO)
    {

        try
        {
            //Conecta a la base de datos
            $database = new Database();
            $db = $database->getConnection();

            //Crea una entidad Session y pasa la conexión a la base de datos
            $session = new Session($db);

            //Obtener los valores desde el SessionDTO que se pasa como parametro
            $userId = $sessionDTO->getUserId();
            $sessionType = $sessionDTO->getSessionType();

            //Establece valores de la entidad Session
            $session->userId = $userId;
            $session->sessionType = $sessionType;

            if
            (
                empty($userId) ||
                empty($sessionType)
            ){
                throw new Exception("Es necesario el userId y el sessionType para poder eleminar el registro", 1);
            }

            //Crea una fila en la tabla sessions basado en los valores de la entidad
            {
                $session->delete();
            }

        } catch (Exception $e) {
            throw $e;
        }
    }
}
