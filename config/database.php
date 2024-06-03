<?php
class DBConnection {
    private $servername = "localhost";
    private $username = "root"; // Modifica con il tuo nome utente MySQL
    private $password = ""; // Modifica con la tua password MySQL
    private $database = "Orizon"; // Modifica con il nome del tuo database
    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connessione fallita: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function closeConnection() {
        $this->conn = null;
    }
}