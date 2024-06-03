<?php
class Country {
    private $conn;
    private $table_name = "Paesi";

    public $id;
    public $country;

    // Costruttore
    public function __construct($db, $id = null, $country = null) {
        $this->conn = $db;
        $this->id = $id;
        $this->country = $country;
    }

    // Creare un nuovo paese
    public function createCountry() {
        $query = "INSERT INTO " . $this->table_name . " (Paese) VALUES (:country)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':country', $this->country);
        return $stmt->execute();
    }

    // Leggere tutti i paesi
    public function getAllCountries() {
        $query = "SELECT id, Paese FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Aggiornare un paese
    public function updateCountry() {
        $query = "UPDATE " . $this->table_name . " SET Paese = :country WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':country', $this->country);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    // Eliminare un paese
    public function deleteCountry() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
}