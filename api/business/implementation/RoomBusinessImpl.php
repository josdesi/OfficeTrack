<?php

class RoomBusinessImpl implements RoomBusiness
{

    public function create($roomDTO)
    {
        try
        {
            //Conecta a la base de datos
            $database = new Database();
            $db = $database->getConnection();

            //Crea una entidad Room y pasa la conexión a la base de dastos
            $room = new Room($db);

            //Obtener los valores desde el RoomDTO que se pasa como parametro
            $roomName = $roomDTO->getRoomName();
            $roomKey = $roomDTO->getRoomKey();
            $description = $roomDTO->getDescription();
            $roomTypeId = $roomDTO->getRoomTypeId();

            //Establece valores de la entidad Room
            $room->roomName = $roomName;
            $room->roomKey = $roomKey;
            $room->description = $description;
            $room->roomTypeId = $roomTypeId;

            //Crea una fila en la tabla rooms basado en los valores de la entidad
            $room->create();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update($roomDTO)
    {
        try {
            //Conecta a la base de datos
            $database = new Database();
            $db = $database->getConnection();

            //Crea una entidad Room y pasa la conexión a la base de dastos
            $room = new Room($db);

            //Obtener los valores desde el RoomDTO que se pasa como parametro
            $roomId = $roomDTO->getRoomId();
            $roomName = $roomDTO->getRoomName();
            $roomKey = $roomDTO->getRoomKey();
            $description = $roomDTO->getDescription();
            $roomTypeId = $roomDTO->getRoomTypeId();

            if (
                empty($roomId)
            ) {
                throw new Exception("Es necesario el roomId para poder actualizar el registro", 1);
            } else {
                //Establece valores de la entidad Room
                $room->roomId = $roomId;
                $room->roomName = $roomName;
                $room->roomKey = $roomKey;
                $room->description = $description;
                $room->roomTypeId = $roomTypeId;

                //Actualiza la fila con el mismo id en la tabla rooms
                $room->update();
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete($roomDTO)
    {
        try {
            //Conecta a la base de datos
            $database = new Database();
            $db = $database->getConnection();

            //Crea una entidad Room y pasa la conexión a la base de dastos
            $room = new Room($db);

            //Obtener los valores desde el RoomDTO que se pasa como parametro
            $roomId = $roomDTO->getRoomId();

            if (
                empty($roomId)
            ) {
                throw new Exception("Es necesario el roomId para poder eleminar el registro", 1);
            } else {
                //Establece valores de la entidad Room
                $room->roomId = $roomId;

                //Elimina la fila con el mismo id en la tabla rooms
                $room->delete();
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function findByRoomkey($roomKey)
    {
        try {
            $database = new Database();
            $db = $database->getConnection();

            //Crea una entidad Room y pasa la conexión a la base de dastos
            $room = new Room($db);

            return $room->findByRoomKey($roomKey);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function findByRoomName($roomName)
    {
        try {
            $database = new Database();
            $db = $database->getConnection();

            //Crea una entidad Room y pasa la conexión a la base de dastos
            $room = new Room($db);

            return $room->findByRoomName($roomName);
        } catch (Exception $e) {
            throw $e;
        }
    }

}
