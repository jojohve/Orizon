<?php

class TripController
{
    public function getTrips()
    {
        // Logica per ottenere tutti i viaggi
        require 'models/Trip.php';
        $trips = Trip::readTrips(); // Supponendo che ci sia un metodo getAll() nel modello Trip
        echo json_encode($trips);
    }

    public function createTrip()
    {
        // Logica per creare un nuovo viaggio
        require 'models/Trip.php';
        $data = json_decode(file_get_contents("php://input"), true);
        $result = Trip::createTrip($data); // Supponendo che ci sia un metodo create() nel modello Trip
        echo json_encode($result);
    }

    public function updateTrip($id)
    {
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
        require 'models/Trip.php';
        $data = json_decode(file_get_contents("php://input"), true);
        $result = Trip::updateTrip($id, $data);
        echo json_encode($result);
    }

    public function deleteTrip($id)
    {
        // Logica per eliminare un viaggio specifico
        require 'models/Trip.php';
        $result = Trip::deleteTrip($id); // Supponendo che ci sia un metodo delete() nel modello Trip
        echo json_encode($result);
    }
}
