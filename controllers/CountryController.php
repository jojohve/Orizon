<?php
require_once (__DIR__ . '/../config/db_connection.php');
require_once (__DIR__ . '/../models/Country.php');

class CountryController
{
    public function readCountries()
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");

        $database = new Database();
        $db = $database->getConnection();

        $country = new Country($db);

        $countries = $country->readCountries();

        if (!empty($countries)) {
            echo json_encode(array("countries" => $countries));
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Nessun Paese Trovato."));
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

        if (!empty($data->Id) && !empty($data->country_name)) {
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
        header("Access-Control-Allow-Methods: PUT");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        $database = new Database();
        $db = $database->getConnection();

        $country = new Country($db);

        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->country_name)) {
            $country->Id = $Id;
            $country->country_name = $data->country_name;

            if ($country->updateCountry()) {
                http_response_code(200);
                echo json_encode(array("message" => "Paese aggiornato correttamente."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Impossibile aggiornare il Paese."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Impossibile aggiornare il Paese, i dati sono incompleti."));
        }
    }

    public function deleteCountry($Id)
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: DELETE");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        $database = new Database();
        $db = $database->getConnection();

        $country = new Country($db);

        $data = json_decode(file_get_contents("php://input"));

        $country->Id = $Id;

        if ($country->deleteCountry()) {
            http_response_code(200);
            echo json_encode(array("message" => "Il Paese è stato eliminato correttamente."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Impossibile eliminare il Paese."));
        }
    }
}