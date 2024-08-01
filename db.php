<?php
$host = 'localhost';
$db = 'kuronokei_tanya';
$user = 'kuronokei_tanya';
$pass = 'wuPPB0*Z';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}