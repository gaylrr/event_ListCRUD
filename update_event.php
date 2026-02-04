<?php
require "config.php";

$eID = $_POST['eID'];
$eName = $_POST['eName'];
$eDate = $_POST['eDate'];
$eLocation = $_POST["eLocation"];
$eDesc = $_POST["eDesc"];


$stmt = $conn->prepare(
  "UPDATE events 
   SET eName = ?, eDate = ?, eLocation = ?, eDesc = ?
   WHERE eID = ?"
);

$stmt->bind_param(
  "ssssi",
  $_POST['eName'],
  $_POST['eDate'],
  $_POST['eLocation'],
  $_POST['eDesc'],
  $_POST['eID']
);

if ($stmt->execute()) {
    header("Location: index.php");
    exit();
} else {
    echo "Update failed: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>