<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM Paesi WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array('message' => 'Paese eliminato con successo.'));
    } else {
        echo json_encode(array('message' => 'Errore durante l\'eliminazione del paese: ' . $conn->error));
    }
} else {
    echo json_encode(array('message' => 'ID del paese mancante.'));
}
$conn->close();