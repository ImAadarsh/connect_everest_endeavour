<?php
$hostname = "82.180.142.204";
$username = "u954141192_connect_everes";
$password = "1@Endeavour@CE";
$database = "u954141192_connect_everes";

try {
    $conn = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die();
}
?> 