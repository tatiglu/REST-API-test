
<?php

$host = 'localhost';
$db = 'your database';
$user = 'your user';
$pass = 'your password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

