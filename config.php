<?php
// Database configuration
$host = 'localhost';
$db   = 'look_gems';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
