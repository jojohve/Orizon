<?php
include 'db_connection.php';
include 'modello.php';

// Creare un'istanza della classe DBConnection
$dbConnection = new DBConnection();

// Ottenere la connessione al database
$connection = $dbConnection->getConnection();

// Creare un'istanza della classe Country passando la connessione al database
$countryModel = new Country($connection);

// Ottenere tutti i paesi
$countries = $countryModel->getAllCountries();

// Impostare l'intestazione per il contenuto JSON
header('Content-Type: application/json');
echo json_encode($countries);

// Chiudere la connessione al database
$dbConnection->closeConnection();