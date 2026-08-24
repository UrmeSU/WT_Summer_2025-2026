<?php

$host = "localhost";    // database server
$user = "root";         // database username
$pass = "";             // database password
$dbname = "summer 25-26"; // database name

// Connection Object-Oriented Style
$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed : " . $conn->connect_error);
}

?>