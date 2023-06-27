<?php
// Connect to the MySQL database
require_once "connectMySQL.php";
// Retrieve movie data from the database
if (isset($_GET["id"])) {
    $id = $_GET["id"];

    // Connect to the MySQL database
    try {
        $pdo = new PDO($attr, $user, $pass, $opts);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int) $e->getCode());
    }
    // Retrieve the movie data from the database
    $query =
        "SELECT category_id, title, director, year FROM movies WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $movie = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the movie exists
    if (!$movie) {
        echo "Invalid movie ID.";
        exit();
    }
} else {
    // Handle the case when the 'id' parameter is not provided or invalid
    echo "Invalid movie ID.";
    exit();
}
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Function to sanitize the input
    function sanitizeInput($input)
    {
        // Trim leading and trailing whitespace
        $input = trim($input);

        // Remove HTML tags
        $input = strip_tags($input);

        // Convert special characters to HTML entities
        $input = htmlentities($input, ENT_QUOTES, "UTF-8");

        // You can apply additional sanitization or validation rules here if needed
        return $input;
    }
    // Sanitize and validate the input
    $id = isset($_POST["id"]) ? sanitizeInput($_POST["id"]) : "";
    $category = isset($_POST["option"]) ? sanitizeInput($_POST["option"]) : "";
    $title = isset($_POST["title"]) ? sanitizeInput($_POST["title"]) : "";
    $director = isset($_POST["director"])
        ? sanitizeInput($_POST["director"])
        : "";
    $year = isset($_POST["year"]) ? sanitizeInput($_POST["year"]) : "";

    // Validate that the year is a number
    if (!is_numeric($year)) {
        // Handle the error
        $_SESSION["message"] = "Invalid year";
        header("Location: updateMovie.php");
        exit();
    }

    // Validate the year range (example: between 1900 and current year)
    $currentYear = date("Y");
    if ($year < 1900 || $year > $currentYear) {
        // Handle the error
        $_SESSION["message"] = "Invalid year range";
        header("Location: updateMovie.php");
        exit();
    }

    // Execute an UPDATE query
    $query =
        "UPDATE movies SET category_id = :category_id, title = :title, director = :director, year = :year WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":category_id", $category);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":director", $director);
    $stmt->bindParam(":year", $year);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->rowCount() > 0) {
        // Movie updated successfully
        header("Location: movies.php");
        exit(); // Make sure to exit after the redirect
    } else {
        echo "Failed to update the movie.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Movie</title>
</head>
<body>
    <h1>Edit Movie</h1>
    <form method="POST" action="updateMovie.php?id=<?php echo $id; ?>">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <fieldset>
            <legend>Edit a Movie</legend>
            <p>Choose a category</p>
            <input type="radio" name="option" id="drama" value="6" required <?php echo $movie[
                "category_id"
            ] == 1
                ? "checked"
                : ""; ?>>
            <label for="drama">Drama</label>
            <input type="radio" name="option" id="action" value="7" <?php echo $movie[
                "category_id"
            ] == 2
                ? "checked"
                : ""; ?>>
            <label for="action">Action</label>
            <input type="radio" name="option" id="comedy" value="8" <?php echo $movie[
                "category_id"
            ] == 3
                ? "checked"
                : ""; ?>>
            <label for="comedy">Comedy</label>
            <input type="radio" name="option" id="sci-fi" value="9" <?php echo $movie[
                "category_id"
            ] == 4
                ? "checked"
                : ""; ?>>
            <label for="sci-fi">Sci-Fi</label>
            <input type="radio" name="option" id="romance" value="10" <?php echo $movie[
                "category_id"
            ] == 5
                ? "checked"
                : ""; ?>>
            <label for="romance">Romance</label>

            <p>Enter a title</p>
            <input type="text" name="title" id="title" placeholder="Title" required value="<?php echo htmlentities(
                $movie["title"]
            ); ?>">

            <p>Enter a director</p>
            <input type="text" name="director" id="director" placeholder="Director" required value="<?php echo htmlentities($movie["director"]); ?>" pattern="[A-Za-z\s]+" title="Please enter a valid director name (letters and spaces only)">

            <p>Enter a year</p>
            <input type="number" name="year" id="year"  placeholder="Year" required min="1900" max="<?php echo date(
                "Y"
            ); ?>" value="<?php echo htmlentities($movie["year"]); ?>">
            <br>
            <br>
            <button type="submit">Update</button>
        </fieldset>
    </form>
</body>
</html>
