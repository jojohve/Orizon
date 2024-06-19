<?php

require_once '../config/database.php';
require_once '../models/Trip.php';

class TripController
{
    public function readTrips()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

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
    }

    public function createTrip()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        $database = new Database();
        $db = $database->getConnection();
        $trip = new Trip($db);
        $data = json_decode(file_get_contents("php://input"));
        if (
            !empty($data->Id) &&
            !empty($data->trip_name) &&
            !empty($data->availability) &&
            !empty($data->countries_ids) &&
            is_array($data->countries_ids)
        ) {
            $trip->Id = $data->Id;
            $trip->trip_name = $data->trip_name;
            $trip->availability = $data->availability;
            $trip->countries_ids = $data->countries_ids;

            if ($trip->createTrip()) {
                http_response_code(201);
                echo json_encode(array("message" => "Viaggio creato correttamente."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Impossibile creare il Viaggio."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Impossibile creare il Viaggio, i dati sono incompleti."));
        }
    }

    public function updateTrip($Id)
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        $database = new Database();
        $db = $database->getConnection();

        $trip = new Trip($db);

        $data = json_decode(file_get_contents("php://input"));

        if (
            !empty($data->Id) &&
            !empty($data->trip_name) &&
            !empty($data->availability) &&
            !empty($data->countries_ids) &&
            is_array($data->countries_ids)
        ) {
            $trip->Id = $data->Id;
            $trip->trip_name = $data->trip_name;
            $trip->availability = $data->availability;
            $trip->countries_ids = $data->countries_ids;

            if ($trip->updateTrip()) {
                http_response_code(200);
                echo json_encode(array("message" => "Viaggio aggiornato correttamente."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Impossibile aggiornare il Viaggio."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Impossibile aggiornare il Viaggio, i dati sono incompleti."));
        }
    }

    public function deleteTrip($Id)
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        $database = new Database();
        $db = $database->getConnection();

        $trip = new Trip($db);

        $data = json_decode(file_get_contents("php://input"));

        $trip->Id = $data->Id;

        if ($trip->deleteTrip()) {
            http_response_code(200);
            echo json_encode(array("risposta" => "Il Viaggio e' stato eliminato"));
        } else {
            http_response_code(503);
            echo json_encode(array("risposta" => "Impossibile eliminare il Viaggio."));
        }
    }
}
