<?php

require_once 'models/Country.php';

class CountryController {
    public function readCountries() {
        $country = new Country();
        $countries = $country->readCountries();
        echo json_encode($countries);
    }

    public function createCountry() {
        $data = json_decode(file_get_contents("php://input"), true);
        $country = new Country();
        $result = $country->createCountry($data);
        echo json_encode($result);
    }

    public function updateCountry($Id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $country = new Country();
        $result = $country->updateCountry($Id, $data);
        echo json_encode($result);
    }

    public function deleteCountry($Id) {
        $country = new Country();
        $result = $country->deleteCountry($Id);
        echo json_encode($result);
    }
}
