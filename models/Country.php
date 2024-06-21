<?php
class Country
{
    private $conn;
    private $table_name = "countries";
    public $Id;
    public $country_name;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // READ ALL COUNTRIES
    function readCountries()
    {
        $query = "SELECT Id, country_name FROM " . $this->table_name;

        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die('Errore nella preparazione della query: ' . $this->conn->error);
        }

        if (!$stmt->execute()) {
            die('Errore nell\'esecuzione della query: ' . $stmt->error);
        }

        $results = $stmt->get_result();

        $countries = array();
        while ($row = $results->fetch_assoc()) {
            $countries[] = $row;
        }

        return $countries;
    }

    // CREATE COUNTRY
    function createCountry()
    {
        $query = "INSERT INTO " . $this->table_name . " (Id, country_name) VALUES (?, ?)";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die('Errore nella preparazione della query: ' . $this->conn->error);
        }

        $stmt->bind_param("is", $this->Id, $this->country_name);

        $this->Id = htmlspecialchars(strip_tags($this->Id));
        $this->country_name = htmlspecialchars(strip_tags($this->country_name));

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // UPDATE COUNTRY
    function updateCountry()
    {
        $query = "UPDATE " . $this->table_name . " SET country_name = ? WHERE Id = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("si", $this->country_name, $this->Id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE COUNTRY
    function deleteCountry()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE Id = ?";

        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die('Errore nella preparazione della query: ' . $this->conn->error);
        }

        $this->Id = htmlspecialchars(strip_tags($this->Id));

        $stmt->bind_param('i', $this->Id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}