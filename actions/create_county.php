<?php
include 'db_connection.php';
include 'modello.php';

$dbConnection = new DBConnection();
$connection = $dbConnection->getConnection();

$countryModel = new Country($connection);
$countryModel->nome_paese = $_POST['nome_paese'];

if ($countryModel->createCountry()) {
    http_response_code(201);
    echo json_encode(["message" => "Paese creato con successo."]);
} else {
    http_response_code(503);
    echo json_encode(["message" => "Impossibile creare il paese."]);
}

$dbConnection->closeConnection();
