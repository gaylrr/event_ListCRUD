<?php
require "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $eName     = $_POST['eName'];
    $eDate = date("Y-m-d H:i:s", strtotime($_POST['eDate']));
    $eLocation = $_POST['eLocation'];
    $eDesc     = $_POST['eDesc'];

    $sql = $conn->prepare(
        "INSERT INTO events (eName, eDate, eLocation, eDesc)
         VALUES (?, ?, ?, ?)"
    );

    $sql->bind_param("ssss", $eName, $eDate, $eLocation, $eDesc);

    if ($sql->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Insert Error: " . $sql->error;
    }

    $sql->close();
    $conn->close();

} else {
    header("Location: create_event.php");
    exit();
}
