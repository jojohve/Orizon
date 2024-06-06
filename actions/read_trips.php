<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connection.php';
include_once 'modello.php';

$database = new Database();
$db = $database->getConnection();

$viaggio = new Trip($db);

$Nome_paese = isset($_GET['Nome_paese']) ? $_GET['Nome_paese'] : null;
$Posti_disponibili = isset($_GET['Posti_disponibili']) ? $_GET['Posti_disponibili'] : null;

$stmt = $viaggio->readTrips($Nome_paese, $Posti_disponibili);
$num = $stmt->rowCount();

if ($num > 0) {

    $viaggio_arr = array();
    $viaggio_arr["viaggi"] = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $viaggio_item = array(
            "Id" => $Id,
            "Nome_viaggio" => $Nome_viaggio,
            "Posti_disponibili" => $Posti_disponibili,
            "Paesi" => $Paesi
        );
        array_push($viaggio_arr["viaggi"], $viaggio_item);
    }
    echo json_encode($viaggio_arr);
} else {
    echo json_encode(
        array("message" => "Nessun Viaggio Trovato.")
    );
}