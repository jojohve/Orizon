<?php
require_once 'database.php';

class Paese
{
    public $id;
    public $paese;
    private $conn;

    public function __construct($conn, $id = null, $paese = null)
    {
        $this->conn = $conn;
        $this->id = $id;
        $this->paese = $paese;
    }

    public function getAllCountries()
    {
        $sql = "SELECT * FROM Paesi";
        $result = $this->conn->query($sql);

        $countries = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $countries[] = $row;
            }
        }
        return $countries;
    }

    public function createCountry()
    {
        $sql = "INSERT INTO Paesi (Paese) VALUES ('$this->paese')";
        if ($this->conn->query($sql) === TRUE) {
            return $this->conn->insert_id;
        } else {
            return false;
        }
    }

    public function updateCountry()
    {
        $sql = "UPDATE Paesi SET Paese='$this->paese' WHERE id=$this->id";
        return $this->conn->query($sql);
    }

    public function deleteCountry()
    {
        $sql = "DELETE FROM Paesi WHERE id=$this->id";
        return $this->conn->query($sql);
    }
}