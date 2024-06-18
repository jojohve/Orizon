<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db_connection.php';
include_once '../models/model.php';

$database = new Database();
$db = $database->getConnection();

$trip = new Trip($db);

$country_name = isset($_GET['country_name']) ? $_GET['country_name'] : null;
$availability = isset($_GET['availability']) ? $_GET['availability'] : null;

$stmt = $trip->readTrips($country_name, $availability);
$num = $stmt->rowCount();

if ($num > 0) {

    $trip_arr = array();
    $trip_arr["trips"] = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $trip_item = array(
            "Id" => $Id,
            "trip_name" => $trip_name,
            "availability" => $availability,
            "countries" => $countries
        );
        array_push($trip_arr["trips"], $trip_item);
    }
    echo json_encode($trip_arr);
} else {
    echo json_encode(
        array("message" => "Nessun Viaggio Trovato.")
    );
}