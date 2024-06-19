<?php

class CountryController {
    public function getCountries() {
        // Logica per ottenere tutti i paesi
        require 'models/Country.php';
        $countries = Country::readCountries(); // Supponendo che ci sia un metodo getAll() nel modello Country
        echo json_encode($countries);
    }

    public function createCountry() {
        // Logica per creare un nuovo paese
        require 'models/Country.php';
        $data = json_decode(file_get_contents("php://input"), true);
        $result = Country::createCountry($data); // Supponendo che ci sia un metodo create() nel modello Country
        echo json_encode($result);
    }

    public function updateCountry($id) {
        // Logica per aggiornare un paese specifico
        require 'models/Country.php';
        $data = json_decode(file_get_contents("php://input"), true);
        $result = Country::updateCountry($id, $data); // Supponendo che ci sia un metodo update() nel modello Country
        echo json_encode($result);
    }

    public function deleteCountry($id) {
        // Logica per eliminare un paese specifico
        require 'models/Country.php';
        $result = Country::deleteCountry($id); // Supponendo che ci sia un metodo delete() nel modello Country
        echo json_encode($result);
    }
}
