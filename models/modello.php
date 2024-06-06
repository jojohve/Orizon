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
    public $paesi_ids = [];
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // READ ALL TRIPS
    function readTrips($Nome_paese = null, $Posti_disponibili = null)
    {
        $query = "
            SELECT
                viaggi.Id,
                viaggi.Nome_viaggio,
                viaggi.Posti_disponibili,
                GROUP_CONCAT(paesi.Nome_paese) AS Paesi
            FROM
                viaggi
            LEFT JOIN
                paesi_nei_viaggi ON viaggi.Id = paesi_nei_viaggi.viaggio_id
            LEFT JOIN
                paesi ON paesi_nei_viaggi.paese_id = paesi.Id";

        $conditions = [];
        if (!is_null($Nome_paese)) {
            $conditions[] = "paesi.Nome_paese LIKE :Nome_paese";
        }
        if (!is_null($Posti_disponibili)) {
            $conditions[] = "viaggi.Posti_disponibili = :Posti_disponibili";
        }

        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(' AND ', $conditions);
        }

        $query .= " GROUP BY viaggi.Id, viaggi.Nome_viaggio, viaggi.Posti_disponibili";

        $stmt = $this->conn->prepare($query);

        if (!is_null($Nome_paese)) {
            $Nome_paese = "%{$Nome_paese}%";
            $stmt->bindParam(':Nome_paese', $Nome_paese);
        }
        if (!is_null($Posti_disponibili)) {
            $stmt->bindParam(':Posti_disponibili', $Posti_disponibili);
        }

        $stmt->execute();

        return $stmt;
    }

    // CREATE TRIP
    function createTrip()
    {
        $query = "INSERT INTO viaggi (Id, Nome_viaggio, Posti_disponibili) VALUES (:Id, :Nome_viaggio, :Posti_disponibili)";

        $stmt = $this->conn->prepare($query);

        $this->Id = htmlspecialchars(strip_tags($this->Id));
        $this->Nome_viaggio = htmlspecialchars(strip_tags($this->Nome_viaggio));
        $this->Posti_disponibili = htmlspecialchars(strip_tags($this->Posti_disponibili));

        $stmt->bindParam(":Id", $this->Id);
        $stmt->bindParam(":Nome_viaggio", $this->Nome_viaggio);
        $stmt->bindParam(":Posti_disponibili", $this->Posti_disponibili);

        if ($stmt->execute()) {
            foreach ($this->paesi_ids as $paese_id) {
                $query_rel = "INSERT INTO paesi_nei_viaggi (viaggio_id, paese_id) VALUES (:viaggio_id, :paese_id)";
                $stmt_rel = $this->conn->prepare($query_rel);
                $stmt_rel->bindParam(':viaggio_id', $this->Id);
                $stmt_rel->bindParam(':paese_id', $paese_id);
                $stmt_rel->execute();
            }
            return true;
        }
        return false;
    }

    //UPDATE TRIP
    function updateTrip()
    {

        $query = "UPDATE viaggi SET Nome_viaggio = :Nome_viaggio, Posti_disponibili = :Posti_disponibili WHERE Id = :Id";

        $stmt = $this->conn->prepare($query);

        $this->Id = htmlspecialchars(strip_tags($this->Id));
        $this->Nome_viaggio = htmlspecialchars(strip_tags($this->Nome_viaggio));
        $this->Posti_disponibili = htmlspecialchars(strip_tags($this->Posti_disponibili));

        $stmt->bindParam(":Id", $this->Id);
        $stmt->bindParam(":Nome_viaggio", $this->Nome_viaggio);
        $stmt->bindParam(":Posti_disponibili", $this->Posti_disponibili);

        if ($stmt->execute()) {
            $query_del_rel = "DELETE FROM paesi_nei_viaggi WHERE viaggio_id = :viaggio_id";
            $stmt_del_rel = $this->conn->prepare($query_del_rel);
            $stmt_del_rel->bindParam(':viaggio_id', $this->Id);
            $stmt_del_rel->execute();
            foreach ($this->paesi_ids as $paese_id) {
                $query_rel = "INSERT INTO paesi_nei_viaggi (viaggio_id, paese_id) VALUES (:viaggio_id, :paese_id)";
                $stmt_rel = $this->conn->prepare($query_rel);
                $stmt_rel->bindParam(':viaggio_id', $this->Id);
                $stmt_rel->bindParam(':paese_id', $paese_id);
                $stmt_rel->execute();
            }
            return true;
        }
        return false;
    }

    //DELETE TRIP
    function deleteTrip()
    {
        $query_rel = "DELETE FROM paesi_nei_viaggi WHERE viaggio_id = :viaggio_id";
        $stmt_rel = $this->conn->prepare($query_rel);
        $stmt_rel->bindParam(':viaggio_id', $this->Id);

        if ($stmt_rel->execute()) {
            $query = "DELETE FROM " . $this->table_name . " WHERE Id = :Id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':Id', $this->Id);
            if ($stmt->execute()) {
                return true;
            }
        }
        return false;
    }
}