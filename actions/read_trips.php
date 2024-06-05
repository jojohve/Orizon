<?php
include 'db_connection.php';
include 'modello.php';

$dbConnection = new DBConnection();
$connection = $dbConnection->getConnection();

$tripModel = new Trip($connection);
$country_id = isset($_GET['paese_id']) ? $_GET['paese_id'] : null;
$available_places = isset($_GET['posti_disponibili']) ? $_GET['posti_disponibili'] : null;

$trips = $tripModel->getTrips($country_id, $available_places);

http_response_code(200);
echo json_encode($trips);

$dbConnection->closeConnection();