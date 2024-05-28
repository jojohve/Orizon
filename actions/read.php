<?php
include 'database.php';

$sql = "SELECT * FROM Paesi";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $countries = array();
    while ($row = $result->fetch_assoc()) {
        $countries[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($countries);
} else {
    echo json_encode(array('message' => 'Nessun paese trovato.'));
}
$conn->close();