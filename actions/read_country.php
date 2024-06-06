<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once 'db_connection.php';
include_once 'modello.php';

$database = new Database();
$db = $database->getConnection();

$paese = new Country($db);

$stmt = $paese->readCountries();
$num = $stmt->rowCount();

if ($num > 0) {

    $paese_arr = array();
    $paese_arr["paesi"] = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $paese_item = array(
            "Id" => $Id,
            "Nome_paese" => $Nome_paese
        );
        array_push($paese_arr["paesi"], $paese_item);
    }
    echo json_encode($paese_arr);
} else {
    echo json_encode(
        array("message" => "Nessun Paese Trovato.")
    );
}