<?php
$host = 'localhost';
$data = 'movielibraryDB';
$user = 'root';
$pass = '123456qwerty';
$chrs = 'utf8mb4';
$attr = "mysql:host=$host;dbname=$data;charset=$chrs";

// PDO = PHP Data Objects
$opts = [
    // Throw exceptions
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

// Create a PDO instance (connect to the database)
try {
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
