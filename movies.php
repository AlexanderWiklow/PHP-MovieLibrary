
<?php
// Connect to the MySQL database
require_once 'connectMySQL.php';
// this try-catch block is used to connect to the database
try {
    $pdo = new PDO($attr, $user, $pass, $opts);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Retrieve movie data from the database
$query = "SELECT movies.id, movies.title, movies.director, movies.year, categories.name AS category_name
          FROM movies
          INNER JOIN categories ON movies.category_id = categories.id";
$stmt = $pdo->query($query);
$movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Display data in an HTML table
?>

<!DOCTYPE html>
<html>
<head>
    <title>Movie List</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Movie List</h1>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Director</th>
                <th>Year</th>
                <th>Category</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <!-- Display the movie data in the table with the help of foreach -->
            <?php foreach ($movies as $movie): ?>
            <tr>
                <!-- htmlentities() is used to escape HTML special characters -->
            <td><?php echo htmlentities($movie['title']); ?></td>
                <td><?php echo htmlentities($movie['director']); ?></td>
                <td><?php echo htmlentities($movie['year']); ?></td>
                <td><?php echo htmlentities($movie['category_name']); ?></td>
                <td>
                    <!-- Pass the movie id to the updateMovie.php file -->
                    <a href="updateMovie.php?id=<?php echo $movie['id']; ?>">Update</a>
                </td>
                <td>
                    <a href="deleteMovie.php?id=<?php echo $movie['id']; ?>">Delete</a>
            </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<!-- Add a new movie -->
    <form method="POST" action="processData.php">
        <fieldset>
        <legend>Add a Movie</legend>
            <p>Choose a category</p>
            <input type="radio" name="option" id="drama" value="1" required> 
            <label for="drama">Drama</label>
            <input type="radio" name="option" id="action" value="2"> 
            <label for="action">Action</label>
            <input type="radio" name="option" id="comedy" value="3"> 
            <label for="comedy">Comedy</label>
            <input type="radio" name="option" id="sci-fi" value="4"> 
            <label for="sci-fi">Sci-Fi</label>
            <input type="radio" name="option" id="romance" value="5"> 
            <label for="romance">Romance</label>

            <p>Enter a title</p>
            <input type="text" name="title" id="title" placeholder="Title" required>

            <p>Enter a director</p>
            <input type="text" name="director" id="director" placeholder="Director" required pattern="[A-Za-z\s]+" title="Please enter a valid director name (letters and spaces only)">


            <p>Enter a year</p>
            <input type="number" name="year" id="year" placeholder="Year" required min="1900" max="<?php echo date('Y'); ?>" required>
            <br>
            <br>
            <button type="submit">STORE</button>
        </fieldset>
    </form>
</body>
</html>