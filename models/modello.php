<?php
class Country
{
    private $conn;
    private $table_name = "paesi";
    public $Id;
    public $Nome_paese;
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // READ ALL COUNTRIES
    function readCountries()
    {
        $query = "SELECT
                    Id, Nome_paese
                FROM
               " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // CREATE COUNTRY
    function createCountry()
    {
        $query = "INSERT INTO " . $this->table_name . " (Id, Nome_paese) VALUES (:Id, :Nome_paese)";

        $stmt = $this->conn->prepare($query);

        $this->Id = htmlspecialchars(strip_tags($this->Id));
        $this->Nome_paese = htmlspecialchars(strip_tags($this->Nome_paese));

        $stmt->bindParam(":Id", $this->Id);
        $stmt->bindParam(":Nome_paese", $this->Nome_paese);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //UPDATE COUNTRY
    function updateCountry()
    {

        $query = "UPDATE " . $this->table_name . " 
        SET Nome_paese = :Nome_paese 
        WHERE Id = :Id";

        $stmt = $this->conn->prepare($query);

        $this->Id = htmlspecialchars(strip_tags($this->Id));
        $this->Nome_paese = htmlspecialchars(strip_tags($this->Nome_paese));

        $stmt->bindParam(":Id", $this->Id);
        $stmt->bindParam(":Nome_paese", $this->Nome_paese);

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

        $this->ISBN = htmlspecialchars(strip_tags($this->Id));


        $stmt->bindParam(1, $this->Id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

}