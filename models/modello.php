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

        $this->Id = htmlspecialchars(strip_tags($this->Id));


        $stmt->bindParam(':Id', $this->Id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}

class Trip
{
    private $conn;
    private $table_name = "viaggi";
    public $Id;
    public $Nome_viaggio;
    public $Posti_disponibili;
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // READ ALL TRIPS
    function readTrips()
    {
        $query = "SELECT v.Id, v.Nome_viaggio, v.Posti_disponibili, GROUP_CONCAT(p.Nome_paese SEPARATOR ', ') as paesi
              FROM viaggi v
              LEFT JOIN paesi_nel_viaggio vp ON v.Id = vp.viaggio_id
              LEFT JOIN paesi p ON vp.paese_id = p.Id
              GROUP BY v.Id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // CREATE TRIP
    function createTrip()
    {
        $query = "INSERT INTO " . $this->table_name . " (Id, Nome_viaggio, Posti_disponibili) VALUES (:Id, :Nome_viaggio, :Posti_disponibili)";

        $stmt = $this->conn->prepare($query);

        $this->Id = htmlspecialchars(strip_tags($this->Id));
        $this->Nome_viaggio = htmlspecialchars(strip_tags($this->Nome_viaggio));
        $this->Posti_disponibili = htmlspecialchars(strip_tags($this->Posti_disponibili));

        $stmt->bindParam(":Id", $this->Id);
        $stmt->bindParam(":Nome_viaggio", $this->Nome_viaggio);
        $stmt->bindParam(":Posti_disponibili", $this->Posti_disponibili);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //UPDATE TRIP
    function updateTrip()
    {

        $query = "UPDATE " . $this->table_name . " 
        SET Nome_viaggio = :Nome_viaggio , Posti_disponibili = :Posti_disponibili
        WHERE Id = :Id";

        $stmt = $this->conn->prepare($query);

        $this->Id = htmlspecialchars(strip_tags($this->Id));
        $this->Nome_viaggio = htmlspecialchars(strip_tags($this->Nome_viaggio));
        $this->Posti_disponibili = htmlspecialchars(strip_tags($this->Posti_disponibili));

        $stmt->bindParam(":Id", $this->Id);
        $stmt->bindParam(":Nome_viaggio", $this->Nome_viaggio);
        $stmt->bindParam(":Posti_disponibili", $this->Posti_disponibili);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //DELETE TRIP
    function deleteTrip()
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