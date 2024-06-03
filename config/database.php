<?php
class DBConnection {
    private $servername = "localhost";
    private $username = "root"; // Il tuo nome utente MySQL
    private $password = ""; // La tua password MySQL
    private $database = "Orizon"; // Il nome del tuo database
    private $conn;

    // Costruttore
    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password);
            // Impostare il modo di gestione degli errori
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connessione fallita: " . $e->getMessage());
        }
    }

    // Funzione per eseguire una query SQL
    public function executeQuery($sql) {
        return $this->conn->query($sql);
    }

    // Funzione per ottenere l'ultimo ID inserito
    public function getLastInsertedId() {
        return $this->conn->lastInsertId();
    }

    // Funzione per chiudere la connessione
    public function closeConnection() {
        $this->conn = null;
    }
}