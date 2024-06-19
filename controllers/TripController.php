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
