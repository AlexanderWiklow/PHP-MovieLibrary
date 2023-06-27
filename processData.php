<?php
require_once 'connectMySQL.php';

// This block of code is executed if the user has submitted the form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $director = $_POST['director'];
    $year = $_POST['year'];
    $categories = $_POST['option'];

    // Function to sanitize the input
function sanitizeInput($input)
{
    // Trim leading and trailing whitespace
    $input = trim($input);

    // Remove HTML tags
    $input = strip_tags($input);

    // Convert special characters to HTML entities
    $input = htmlentities($input, ENT_QUOTES, 'UTF-8');

    return $input;
}
    // Sanitize the input
    $category = isset($_POST['option']) ? sanitizeInput($_POST['option']) : '';
$title = isset($_POST['title']) ? sanitizeInput($_POST['title']) : '';
$director = isset($_POST['director']) ? sanitizeInput($_POST['director']) : '';
$year = isset($_POST['year']) ? sanitizeInput($_POST['year']) : '';

// Validate the year range (example: between 1900 and current year)
$currentYear = date('Y');
if ($year < 1900 || $year > $currentYear) {
    // Handle the error
    $_SESSION['message'] = "Invalid year range";
    header('Location: movie.php');
    exit;
}

    // Insert the movie data into the database
    try {
        $pdo = new PDO($attr, $user, $pass, $opts);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }

    // Retrieve the selected category name based on the option value
    $categoryName = '';

    if ($categories === '1') {
        $categoryName = 'Drama';
    } elseif ($categories === '2') {
        $categoryName = 'Action';
    } elseif ($categories === '3') {
        $categoryName = 'Comedy';
    } elseif ($categories === '4') {
        $categoryName = 'Sci-Fi';
    } elseif ($categories === '5') {
        $categoryName = 'Romance';
    }

    // Get the category id from the category table based on the category name
    $query = "SELECT id FROM categories WHERE name = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$categoryName]);
    $category_id = $stmt->fetchColumn();

    // Prepare the INSERT statement with the category id
    $query = "INSERT INTO movies (title, director, year, category_id) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$title, $director, $year, $category_id]);

    // Check if the INSERT statement was successful
    if ($stmt) {
        // Set a session variable with a success message
        $_SESSION['message'] = "Movie added successfully";
    } else {
        // Set a session variable with an error message
        $_SESSION['message'] = "Movie could not be added";
    }

    // Redirect to the desired page
    header('Location: movies.php');
    exit; // Important to exit after the redirect
}
?>
