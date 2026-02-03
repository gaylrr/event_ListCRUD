<?php
require "config.php";

$eID = $_POST['eID'];
$eName = $_POST['eName'];
$eDate = $_POST['eDate'];
$eLocation = $_POST["eLocation"];
$eDesc = $_POST["eDesc"];

$sql = "UPDATE events SET eName='$eName', eDate='$eDate', eLocation='$eLocation', eDesc='$eDesc' WHERE eID=$eID";
if ($conn->query($sql) === TRUE) {  
    header("Location: index.php");
    exit();
} 
else {
    echo "Error udpating information." . $sql . "<br>" . $conn->error;
}
$conn->close();