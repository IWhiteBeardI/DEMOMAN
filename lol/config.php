<?php

$host = "localhost";
$username = "root";
$password = "";
$dbname = "DEMO";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Функция для подготовленных выражений
function prepareQuery($sql) {
    global $conn;
    return $conn->prepare($sql);
}
