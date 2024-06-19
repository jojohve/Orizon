<?php

class Trip
{
    private $conn;
    private $table_name = "trips";
    public $Id;
    public $trip_name;
    public $availability;
    public $countries_ids = [];
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // READ ALL TRIPS
    function readTrips($country_name = null, $availability = null)
    {
        $query = "
            SELECT
                trips.Id,
                trips.trip_name,
                trips.availability,
                GROUP_CONCAT(countries.country_name) AS countries
            FROM
                trips
            LEFT JOIN
                country_trip ON trips.Id = country_trip.trip_id
            LEFT JOIN
                countries ON country_trip.country_id = countries.Id";

        $conditions = [];
        if (!is_null($country_name)) {
            $conditions[] = "countries.country_name LIKE :country_name";
        }
        if (!is_null($availability)) {
            $conditions[] = "trips.availability = :availability";
        }

        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(' AND ', $conditions);
        }

        $query .= " GROUP BY trips.Id, trips.trip_name, trips.availability";

        $stmt = $this->conn->prepare($query);

        if (!is_null($country_name)) {
            $country_name = "%{$country_name}%";
            $stmt->bindParam(':country_name', $country_name);
        }
        if (!is_null($availability)) {
            $stmt->bindParam(':availability', $availability);
        }

        $stmt->execute();

        return $stmt;
    }

    // CREATE TRIP
    function createTrip()
    {
        $query = "INSERT INTO trips (Id, trip_name, availability) VALUES (:Id, :trip_name, :availability)";

        $stmt = $this->conn->prepare($query);

        $this->Id = htmlspecialchars(strip_tags($this->Id));
        $this->trip_name = htmlspecialchars(strip_tags($this->trip_name));
        $this->availability = htmlspecialchars(strip_tags($this->availability));

        $stmt->bindParam(":Id", $this->Id);
        $stmt->bindParam(":trip_name", $this->trip_name);
        $stmt->bindParam(":availability", $this->availability);

        if ($stmt->execute()) {
            foreach ($this->countries_ids as $country_id) {
                $query_rel = "INSERT INTO country_trip (trip_id, country_id) VALUES (:trip_id, :country_id)";
                $stmt_rel = $this->conn->prepare($query_rel);
                $stmt_rel->bindParam(':trip_id', $this->Id);
                $stmt_rel->bindParam(':country_id', $country_id);
                $stmt_rel->execute();
            }
            return true;
        }
        return false;
    }

    //UPDATE TRIP
    function updateTrip()
    {

        $query = "UPDATE trips SET trip_name = :trip_name, availability = :availability WHERE Id = :Id";

        $stmt = $this->conn->prepare($query);

        $this->Id = htmlspecialchars(strip_tags($this->Id));
        $this->trip_name = htmlspecialchars(strip_tags($this->trip_name));
        $this->availability = htmlspecialchars(strip_tags($this->availability));

        $stmt->bindParam(":Id", $this->Id);
        $stmt->bindParam(":trip_name", $this->trip_name);
        $stmt->bindParam(":availability", $this->availability);

        if ($stmt->execute()) {
            $query_del_rel = "DELETE FROM country_trip WHERE trip_id = :trip_id";
            $stmt_del_rel = $this->conn->prepare($query_del_rel);
            $stmt_del_rel->bindParam(':trip_id', $this->Id);
            $stmt_del_rel->execute();
            foreach ($this->countries_ids as $country_id) {
                $query_rel = "INSERT INTO country_trip (trip_id, country_id) VALUES (:trip_id, :country_id)";
                $stmt_rel = $this->conn->prepare($query_rel);
                $stmt_rel->bindParam(':trip_id', $this->Id);
                $stmt_rel->bindParam(':country_id', $country_id);
                $stmt_rel->execute();
            }
            return true;
        }
        return false;
    }

    //DELETE TRIP
    function deleteTrip()
    {
        $query_rel = "DELETE FROM country_trip WHERE trip_id = :trip_id";
        $stmt_rel = $this->conn->prepare($query_rel);
        $stmt_rel->bindParam(':trip_id', $this->Id);

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