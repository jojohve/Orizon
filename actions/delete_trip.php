<?php
include 'db_connection.php';
include 'modello.php';

$dbConnection = new DBConnection();
$connection = $dbConnection->getConnection();

$tripModel = new Trip($connection);
$tripModel->id = $_POST['Id'];

if ($tripModel->deleteTrip()) {
    http_response_code(200);
    echo json_encode(["message" => "Viaggio eliminato con successo."]);
} else {
    http_response_code(503);
    echo json_encode(["message" => "Impossibile eliminare il viaggio."]);
}

$dbConnection->closeConnection();
