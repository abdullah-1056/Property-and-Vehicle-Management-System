<?php
$servername = getenv('DB_HOST') ?: 'localhost';
$username = getenv('DB_USERNAME') ?: 'pvmuser';
$password = getenv('DB_PASSWORD') ?: 'pvm123';
$db_name = getenv('DB_NAME') ?: 'rent';
$port = getenv('DB_PORT') ?: 3306;

$conn = new mysqli($servername, $username, $password, $db_name, $port);

if ($conn->connect_error) {
    die("connection failed: " . $conn->connect_error);
}
?>