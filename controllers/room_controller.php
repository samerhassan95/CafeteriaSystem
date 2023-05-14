<?php

include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/models/room_model.php');

class RoomController
{
    private $roomModel;

    public function __construct()
    {
        $this->roomModel = new RoomModel(include($_SERVER["DOCUMENT_ROOT"] . '/CafeteriaSystem/config/database.php'));
    }

    public function index()
    {
        // Fetch a list of all rooms from the database
        return $this->roomModel->getAllRooms();
    }

    public function show($id)
    {
        // Fetch details for a specific room from the database
        $room = $this->roomModel->getRoomById($id);

        // If the room exists, display its details
        if ($room) {
            echo "<h1>Room " . $room['name'] . "</h1>";
        } else {
            echo "<p>Room not found</p>";
        }
    }

    public function create()
    {
        // Display a form to create a new room
        echo "<form method='post'>";
        echo "<label>Name:</label><input type='text' name='name'>";
        echo "<input type='submit' value='Save'>";
        echo "</form>";

        // If the form has been submitted, create a new room
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $this->roomModel->createRoom($name);
            header("Location: /index.php");
            exit;
        }
    }

    public function edit($id)
    {
        // Fetch details for a specific room from the database
        $room = $this->roomModel->getRoomById($id);

        // If the room exists, display a form to edit it
        if ($room) {
            echo "<form method='post'>";
            echo "<label>Name:</label><input type='text' name='name' value='" . $room['name'] . "'>";
            echo "<input type='submit' value='Save'>";
            echo "</form>";

            // If the form has been submitted, update the room
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $name = $_POST['name'];
                $this->roomModel->updateRoom($id, $name);
                header("Location: /index.php");
                exit;
            }
        } else {
            echo "<p>Room not found</p>";
        }
    }

    public function delete($id)
    {
        // Delete the specified room from the database
        $this->roomModel->deleteRoom($id);

        header("Location: /index.php");
        exit;
    }
}
