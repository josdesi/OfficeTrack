<?php

class UserBusinessImpl implements UserBusiness
{

    public function createUser($userDTO)
    {
        try {
            $database = new Database();
            $db = $database->getConnection();
            $user = new User($db);

            $user->username = $userDTO->getUsername();
            $user->password = $userDTO->getPassword();
            $user->email = $userDTO->getEmail();
            $user->emailToken = $userDTO->getEmailToken();
            $user->create();

            return $userDTO;

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateUser($userDTO)
    {

        $database = new Database();
        $db = $database->getConnection();
        $user = new User($db);

        $user->id = $userDTO->getId();
        $user->username = $userDTO->getUsername();
        $user->password = $userDTO->getPassword();
        $user->name = $userDTO->getName();
        $user->fatherSurname = $userDTO->getFatherSurname();
        $user->motherSurname = $userDTO->getMotherSurname();
        $user->phone = $userDTO->getPhone();
        $user->email = $userDTO->getEmail();
        $user->email = $userDTO->getEmailToken();
        $user->email = $userDTO->getVerify();

        try {
            $user->update();
            return $userDTO;
        } catch (Exception $e) {
            throw $e;
            return null;
        }
    }

    public function deleteUser($userDTO)
    {

        $database = new Database();
        $db = $database->getConnection();
        $user = new User($db);

        $user->username = $userDTO->getUsername();

        try {
            $user->delete();
            return true;
        } catch (Exception $e) {
            throw $e;
            return null;
        }
    }

    public function verifyPassword($username, $password)
    {
        $database = new Database();
        $db = $database->getConnection();
        $user = new User($db);
        return $user->verifyPassword($username, $password);
    }

    public function confirmEmailToken($emailToken)
    {
        $database = new Database();
        $db = $database->getConnection();
        $user = new User($db);
        return $user->confirmEmailToken($emailToken);
    }

    public function findUserByEmail($email)
    {
        try {
            $database = new Database();
            $db = $database->getConnection();
            $user = new User($db);
            return $user->findUserByEmail($email);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function findUserByUsername($username)
    {
        try {
            $database = new Database();
            $db = $database->getConnection();
            $user = new User($db);
            return $user->findUserByUsername($username);
        } catch (Exception $e) {
            throw $e;

        }

    }
}
