<?php

class UserBusinessImpl implements UserBusiness
{

    public function create($userDTO)
    {
        try
        {
            //Conecta a la base de datos
            $database = new Database();
            $db = $database->getConnection();

            //Crea una entidad User y pasa la conexión a la base de dastos
            $user = new User($db);

            //Obtener los valores desde el UserDTO que se pasa como parametro
            $userId = $userDTO->getUserId();
            $username = $userDTO->getUsername();
            $password = $userDTO->getPassword();
            $name = $userDTO->getName();
            $fatherSurname = $userDTO->getFatherSurname();
            $motherSurname = $userDTO->getMotherSurname();
            $phone = $userDTO->getPhone();
            $email = $userDTO->getEmail();
            $emailToken = $userDTO->getEmailToken();
            $verify = $userDTO->getVerify();

            //Establece valores de la entidad User
            $user->userId = $userId;
            $user->username = $username;
            $user->password = $password;
            $user->name = $name;
            $user->fatherSurname = $fatherSurname;
            $user->motherSurname = $motherSurname;
            $user->phone = $phone;
            $user->email = $email;
            $user->emailToken = $emailToken;
            $user->verify = $verify;

            //Crea una fila en la tabla users basado en los valores de la entidad
            $user->create();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update($userDTO)
    {

        try
        {
            //Conecta a la base de datos
            $database = new Database();
            $db = $database->getConnection();

            //Crea una entidad User y pasa la conexión a la base de dastos
            $user = new User($db);

            //Obtener los valores desde el UserDTO que se pasa como parametro
            $userId = $userDTO->getUserId();
            $username = $userDTO->getUsername();
            $password = $userDTO->getPassword();
            $name = $userDTO->getName();
            $fatherSurname = $userDTO->getFatherSurname();
            $motherSurname = $userDTO->getMotherSurname();
            $phone = $userDTO->getPhone();
            $email = $userDTO->getEmail();
            $emailToken = $userDTO->getEmailToken();
            $verify = $userDTO->getVerify();

            if (
                empty($userId)
            ) {
                throw new Exception("Es necesario el userId para poder actualizar el registro", 1);
            } else {
                //Establece valores de la entidad User
                $user->userId = $userId;
                $user->username = $username;
                $user->password = $password;
                $user->name = $name;
                $user->fatherSurname = $fatherSurname;
                $user->motherSurname = $motherSurname;
                $user->phone = $phone;
                $user->email = $email;
                $user->emailToken = $emailToken;
                $user->verify = $verify;

                //Actualiza la fila con el mismo id en la tabla users
                $user->update();
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete($userDTO)
    {
        try
        {
            //Conecta a la base de datos
            $database = new Database();
            $db = $database->getConnection();

            //Crea una entidad User y pasa la conexión a la base de dastos
            $user = new User($db);

            //Obtener los valores desde el UserDTO que se pasa como parametro
            $userId = $userDTO->getUserId();

            if (
                empty($userId)
            ) {
                throw new Exception("Es necesario el userId para poder eliminar el registro", 1);
            } else {
                //Establece valores de la entidad User
                $user->userId = $userId;

                //Actualiza la fila con el mismo id en la tabla users
                $user->delete();
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function findByEmail($email)
    {
        try {
            $database = new Database();
            $db = $database->getConnection();

            //Crea una entidad User y pasa la conexión a la base de dastos
            $user = new User($db);

            return $user->findByEmail($email);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function findByUsername($username)
    {
        try {
            $database = new Database();
            $db = $database->getConnection();

            //Crea una entidad User y pasa la conexión a la base de dastos
            $user = new User($db);

            return $user->findByUsername($username);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function findByUserId($userId)
    {
        try {
            $database = new Database();
            $db = $database->getConnection();

            //Crea una entidad User y pasa la conexión a la base de dastos
            $user = new User($db);

            return $user->findByUserId($userId);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function findByEmailToken($emailToken)
    {
        try {
            $database = new Database();
            $db = $database->getConnection();

            //Crea una entidad User y pasa la conexión a la base de dastos
            $user = new User($db);

            return $user->findByEmailToken($emailToken);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function verifyPassword($passwordFromDB, $passwordFromClient)
    {
        return password_verify($passwordFromClient, $passwordFromDB);
    }
}
