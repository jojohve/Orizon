<?php

require_once 'models/Trip.php';

class TripController {
    public function readTrips() {
        $trip = new Trip();
        $trips = $trip->readTrips();
        echo json_encode($trips);
    }

    public function createTrip() {
        $data = json_decode(file_get_contents("php://input"), true);
        $trip = new Trip();
        $result = $trip->createTrip($data);
        echo json_encode($result);
    }

    public function updateTrip($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $trip = new Trip();
        $result = $trip->updateTrip($id, $data);
        echo json_encode($result);
    }

    public function deleteTrip($id) {
        $trip = new Trip();
        $result = $trip->deleteTrip($id);
        echo json_encode($result);
    }
}
