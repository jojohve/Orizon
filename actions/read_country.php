<?php
include 'db_connection.php';
include 'modello.php';

$dbConnection = new DBConnection();
$connection = $dbConnection->getConnection();

$countryModel = new Country($connection);
$paesi = $countryModel->readCountries();

http_response_code(200);
echo json_encode($paesi);

$dbConnection->closeConnection();
