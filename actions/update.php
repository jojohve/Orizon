<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['paese'])) {
    $id = $_POST['id'];
    $paese = $_POST['paese'];

    $sql = "UPDATE Paesi SET Paese='$paese' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array('message' => 'Paese aggiornato con successo.'));
    } else {
        echo json_encode(array('message' => 'Errore durante l\'aggiornamento del paese: ' . $conn->error));
    }
} else {
    echo json_encode(array('message' => 'Parametri mancanti.'));
}
$conn->close();