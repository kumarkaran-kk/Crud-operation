<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "healthrecord";

// Establish database connection
$conn = mysqli_connect($servername, $username, $password, $database);
if ($conn) {
    //echo "connection ok";
} else {
    echo "Connection failed: " . mysqli_connect_error(0);
}
