<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "carwebsite";

try {
	$pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	echo json_encode("Connection failed: " . $e->getMessage())	;
}
