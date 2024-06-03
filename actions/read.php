<?php
include 'database.php';
include 'table.php';

// Creare un'istanza di connessione al database
$dbConnection = new DBConnection();

// Creare un'istanza della classe Country
$countryModel = new Country($dbConnection->conn);

// Ottenere tutti i paesi
$countries = $countryModel->getAllCountries();

// Impostare l'intestazione per il contenuto JSON
header('Content-Type: application/json');
echo json_encode($countries);

// Chiudere la connessione al database
$dbConnection->closeConnection();
?>