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
}