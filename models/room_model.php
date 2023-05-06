<?php

// models/room_model.php

class RoomModel
{
    private $db;

    public function __construct(PDO $database)
    {
        $this->db = $database;
    }

    public function getAllRooms()
    {
        $stmt = $this->db->prepare('SELECT * FROM rooms');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRoomById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM rooms WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createRoom($name)
    {
        $stmt = $this->db->prepare('INSERT INTO rooms (name) VALUES (?)');
        return $stmt->execute([$name]);
    }

    public function updateRoom($id, $name)
    {
        $stmt = $this->db->prepare('UPDATE rooms SET name = ? WHERE id = ?');
        return $stmt->execute([$name, $id]);
    }

    public function deleteRoom($id)
    {
        $stmt = $this->db->prepare('DELETE FROM rooms WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
