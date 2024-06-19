<?php

include_once '../config/db_connection.php';
require_once '../models/Country.php';

class CountryController
{
    public function readCountries()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

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
    }

    public function createCountry()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        $database = new Database();
        $db = $database->getConnection();
        $country = new Country($db);
        $data = json_decode(file_get_contents("php://input"));
        if (
            !empty($data->Id) &&
            !empty($data->country_name)
        ) {
            $country->Id = $data->Id;
            $country->country_name = $data->country_name;

            if ($country->createCountry()) {
                http_response_code(201);
                echo json_encode(array("message" => "Paese creato correttamente."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Impossibile creare il Paese."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Impossibile creare il Paese, i dati sono incompleti."));
        }
    }

    public function updateCountry($Id)
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


        $database = new Database();
        $db = $database->getConnection();

        $country = new Country($db);

        $data = json_decode(file_get_contents("php://input"));

        $country->Id = $data->Id;
        $country->country_name = $data->country_name;

        if ($country->updateCountry()) {
            http_response_code(200);
            echo json_encode(array("risposta" => "Paese aggiornato"));
        } else {
            http_response_code(503);
            echo json_encode(array("risposta" => "Impossibile aggiornare il Paese"));
        }
    }

    public function deleteCountry($Id)
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        $database = new Database();
        $db = $database->getConnection();

        $country = new Country($db);

        $data = json_decode(file_get_contents("php://input"));

        $country->Id = $data->Id;

        if ($country->deleteCountry()) {
            http_response_code(200);
            echo json_encode(array("risposta" => "Il Paese e' stato eliminato"));
        } else {
            http_response_code(503);
            echo json_encode(array("risposta" => "Impossibile eliminare il Paese."));
        }
    }
}
