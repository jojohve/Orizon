<?php
if (file_exists(__DIR__ . '/../.env')) {
    $env = parse_ini_file(__DIR__ . '/../.env');
    foreach ($env as $key => $value) {
        putenv("$key=$value");
    }
}
class Database
{
    private $host = getenv('DB_HOST');
    private $db_name = getenv('DB_DATABASE');
    private $username = getenv('DB_USERNAME');
    private $password = getenv('DB_PASSWORD');
    public $conn;
    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection Error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}