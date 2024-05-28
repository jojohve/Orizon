<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "Orizon";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}