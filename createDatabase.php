<?php
require_once 'connectMySQL.php';
// this try-catch block is used to connect to the database
try {
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
// Retrieve movie data from the database
$query = "CREATE TABLE IF NOT EXISTS categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL
)";
// Execute the query
$result = $pdo->query($query);
// Insert the category data into the database
$query = "INSERT INTO categories (name) VALUES ('Drama'), ('Action'), ('Comedy'), ('Sci-Fi'), ('Romance')";
$result = $pdo->query($query);
// Create the movies table
$query = "CREATE TABLE IF NOT EXISTS movies (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  director VARCHAR(255) NOT NULL,
  year INT NOT NULL,
  category_id INT NOT NULL,
  FOREIGN KEY (category_id) REFERENCES categories(id)
)";

$result = $pdo->query($query);
// Insert example movie data into the database
$title = 'The Whale Rider';
$director = 'Terry Jones';
$year = 2020;
$category_name = 'Drama'; // Specify the category name for the movie
$category_id = add_category($pdo, $category_name); // Add the category and retrieve its ID

add_movie($pdo, $title, $director, $year, $category_id);
// This function adds a new category to the database
function add_category($pdo, $category_name)
{
  $stmt = $pdo->prepare('INSERT INTO categories (name) VALUES (?)');
  $stmt->bindValue(1, $category_name, PDO::PARAM_STR);
  $stmt->execute();
  
    return $pdo->lastInsertId(); // Retrieve the auto-generated ID for the new category
}
// This function adds a new movie to the database
function add_movie($pdo)
{
    // Check if the database contains any movie
    $stmt = $pdo->prepare('SELECT COUNT(*) FROM movies');
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count === 0) {
        // Database does not contain any movies, add an example movie
        $exampleTitle = "Example Movie";
        $exampleDirector = "Example Director";
        $exampleYear = 2023;
        $exampleCategoryId = 1; // Change the category ID as per your database

        $stmt = $pdo->prepare('INSERT INTO movies (title, director, year, category_id) VALUES (?, ?, ?, ?)');

        $stmt->bindParam(1, $exampleTitle, PDO::PARAM_STR, 255);
        $stmt->bindParam(2, $exampleDirector, PDO::PARAM_STR, 255);
        $stmt->bindParam(3, $exampleYear, PDO::PARAM_INT);
        $stmt->bindParam(4, $exampleCategoryId, PDO::PARAM_INT);

        $stmt->execute();
    } else {
        // Database already contains movies, do not add a movie
        return;
    }
}

?>
