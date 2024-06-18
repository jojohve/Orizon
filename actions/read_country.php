<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/db_connection.php';
include_once '../models/model.php';

$database = new Database();
$db = $database->getConnection();

$country = new Country($db);

$stmt = $country->readCountries();
$num = $stmt->rowCount();

if ($num > 0) {

    $country_arr = array();
    $country_arr["countries"] = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $country_item = array(
            "Id" => $Id,
            "country_name" => $country_name
        );
        array_push($country_arr["countries"], $country_item);
    }
    echo json_encode($country_arr);
} else {
    echo json_encode(
        array("message" => "Nessun Paese Trovato.")
    );
}