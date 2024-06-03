<?php
include 'table.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['paese'])) {
    $paese = $_POST['paese'];

    $sql = "INSERT INTO Paesi (Paese) VALUES ('$paese')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array('message' => 'Paese creato con successo.'));
    } else {
        echo json_encode(array('message' => 'Errore durante la creazione del Paese: ' . $conn->error));
    }
} else {
    echo json_encode(array('message' => 'Parametri mancanti.'));
}
$conn->close();