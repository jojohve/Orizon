<?php
include 'db_connection.php';
include 'modello.php';

$dbConnection = new DBConnection();
$connection = $dbConnection->getConnection();

$tripModel = new Trip($connection);
$tripModel->posti_disponibili = $_POST['posti_disponibili'];
$tripModel->paesi_ids = explode(',', $_POST['paesi_ids']);

if ($tripModel->createTrip()) {
    http_response_code(201);
    echo json_encode(["message" => "Viaggio creato con successo."]);
} else {
    http_response_code(503);
    echo json_encode(["message" => "Impossibile creare il viaggio."]);
}

$dbConnection->closeConnection();