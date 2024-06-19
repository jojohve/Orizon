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
        $query = "SELECT
                    Id, country_name
                FROM
               " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // CREATE COUNTRY
    function createCountry()
    {
        $query = "INSERT INTO " . $this->table_name . " (Id, country_name) VALUES (:Id, :country_name)";

        $stmt = $this->conn->prepare($query);

        $this->Id = htmlspecialchars(strip_tags($this->Id));
        $this->country_name = htmlspecialchars(strip_tags($this->country_name));

        $stmt->bindParam(":Id", $this->Id);
        $stmt->bindParam(":country_name", $this->country_name);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //UPDATE COUNTRY
    function updateCountry()
    {

        $query = "UPDATE " . $this->table_name . " 
        SET country_name = :country_name 
        WHERE Id = :Id";

        $stmt = $this->conn->prepare($query);

        $this->Id = htmlspecialchars(strip_tags($this->Id));
        $this->country_name = htmlspecialchars(strip_tags($this->country_name));

        $stmt->bindParam(":Id", $this->Id);
        $stmt->bindParam(":country_name", $this->country_name);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //DELETE COUNTRY
    function deleteCountry()
    {

        $query = "DELETE FROM " . $this->table_name . " WHERE Id = :Id";

        $stmt = $this->conn->prepare($query);

        $this->Id = htmlspecialchars(strip_tags($this->Id));


        $stmt->bindParam(':Id', $this->Id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}