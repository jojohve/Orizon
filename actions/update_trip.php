<?php
include 'db_connection.php';
include 'modello.php';

$dbConnection = new DBConnection();
$connection = $dbConnection->getConnection();

$tripModel = new Trip($connection);
$tripModel->id = $_POST['Id'];
$tripModel->posti_disponibili = $_POST['Posti_disponibili'];
$tripModel->paesi_ids = explode(',', $_POST['paese_id']);

if ($tripModel->updateTrip()) {
    http_response_code(200);
    echo json_encode(["message" => "Viaggio aggiornato con successo."]);
} else {
    http_response_code(503);
    echo json_encode(["message" => "Impossibile aggiornare il viaggio."]);
}

$dbConnection->closeConnection();
