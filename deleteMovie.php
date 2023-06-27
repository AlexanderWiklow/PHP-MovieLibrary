<?php
// Connect to the MySQL database
require_once 'connectMySQL.php';

// Retrieve the movie ID from the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $pdo = new PDO($attr, $user, $pass, $opts);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

    // Perform the deletion operation
    $query = "DELETE FROM movies WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    // Redirect the user after deletion
    header("Location: movies.php");
    exit();
} else {
    // Handle the case when the 'id' parameter is not provided or invalid
    echo "Invalid movie ID.";
    exit();
}
