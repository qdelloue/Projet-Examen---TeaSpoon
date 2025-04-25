<?php

$host = "quentsn290.mysql.db";
$user = "quentsn290";
$pass = "Test01234";
$dbname = "quentsn290";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}