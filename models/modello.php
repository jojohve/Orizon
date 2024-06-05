<?php
class Country
{
    private $conn;
    private $table_name = "paesi";

    public $id;
    public $nome_paese;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function readCountries()
    {
        $query = "SELECT Id, Nome_paese FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createCountry()
    {
        $query = "INSERT INTO " . $this->table_name . " (Nome_paese) VALUES (:Nome_paese)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':Nome_paese', $this->nome_paese);
        return $stmt->execute();
    }

    public function updateCountry()
    {
        $query = "UPDATE " . $this->table_name . " SET Nome_paese = :Nome_paese WHERE Id = :Id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':Nome_paese', $this->nome_paese);
        $stmt->bindParam(':Id', $this->id);
        return $stmt->execute();
    }

    public function deleteCountry()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE Id = :Id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':Id', $this->id);
        return $stmt->execute();
    }
}

class Trip
{
    private $conn;
    private $table_name = "viaggi";

    public $id;
    public $posti_disponibili;
    public $paesi_ids;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createTrip()
    {
        $this->conn->beginTransaction();
        try {
            $query = "INSERT INTO " . $this->table_name . " (Posti_disponibili) VALUES (:Posti_disponibili)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':Posti_disponibili', $this->posti_disponibili);
            $stmt->execute();
            $trip_id = $this->conn->lastInsertId();

            $query = "INSERT INTO paesi_nei_viaggi (viaggio_id, paese_id) VALUES (:viaggio_id, :paese_id)";
            $stmt = $this->conn->prepare($query);
            foreach ($this->paesi_ids as $paese_id) {
                $stmt->bindParam(':viaggio_id', $trip_id);
                $stmt->bindParam(':paese_id', $paese_id);
                $stmt->execute();
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function updateTrip()
    {
        $this->conn->beginTransaction();
        try {
            $query = "UPDATE " . $this->table_name . " SET Posti_disponibili = :Posti_disponibili WHERE Id = :Id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':Posti_disponibili', $this->posti_disponibili);
            $stmt->bindParam(':Id', $this->id);
            $stmt->execute();

            $query = "DELETE FROM paesi_nei_viaggi WHERE viaggio_id = :Id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':Id', $this->id);
            $stmt->execute();

            $query = "INSERT INTO paesi_nei_viaggi (viaggio_id, paese_id) VALUES (:viaggio_id, :paese_id)";
            $stmt = $this->conn->prepare($query);
            foreach ($this->paesi_ids as $paese_id) {
                $stmt->bindParam(':viaggio_id', $this->id);
                $stmt->bindParam(':paese_id', $paese_id);
                $stmt->execute();
            }

            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function deleteTrip()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE Id = :Id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':Id', $this->id);
        return $stmt->execute();
    }

    public function getTrips($paese_id = null, $posti_disponibili = null)
    {
        $query = "SELECT v.Id, v.Posti_disponibili, GROUP_CONCAT(p.Nome_paese SEPARATOR ', ') AS paesi
                  FROM viaggi v
                  JOIN paesi_nei_viaggi vp ON v.Id = vp.viaggio_id
                  JOIN paesi p ON vp.paese_id = p.Id";

        $conditions = [];
        if ($paese_id) {
            $conditions[] = "vp.paese_id = :paese_id";
        }
        if ($posti_disponibili) {
            $conditions[] = "v.Posti_disponibili >= :Posti_disponibili";
        }

        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        $query .= " GROUP BY v.Id";

        $stmt = $this->conn->prepare($query);

        if ($paese_id) {
            $stmt->bindParam(':paese_id', $paese_id);
        }
        if ($posti_disponibili) {
            $stmt->bindParam(':Posti_disponibili', $posti_disponibili);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}