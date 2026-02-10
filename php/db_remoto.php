<?php
$servername = "localhost";
$username = "u439262836_indicacao";
$password = "&I2S;zlr";
$dbname = "u439262836_indicacao";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>