## Movie List 🎥

This project is a simple web application that displays a list of movies retrieved from a MySQL database. Users can also add new movies, edit existing ones to the database through a form or delete.

### Features ✨

- Displays a table of movies with their title, director, year, and category.
- Allows users to update and delete movies from the list.
- Provides a form to add new movies, including title, director, year, and category selection.

### Technologies Used 🛠️

- PHP: Used for server-side scripting to connect to the MySQL database and retrieve movie data.
- MySQL: Stores the movie data in a database.
- HTML: Renders the movie list table and form on the web page.
- CSS: Styles the web page to enhance the visual presentation.

### Files 📁

1. `connectMySQL.php`: Connects to the MySQL database using PDO.
2. `createDatabase.php`: Creates the database.
3. `movies.php`: The main PHP file that displays the movie list and provides the form to add new movies.
4. `updateMovie.php`: Allows users to edit an existing movie's information.
5. `deleteMovie.php`: Deletes a movie from the database.
6. `style.css`: The CSS file to style the movie list and form.

## Getting Started

To start this program, follow the steps below:

1. Ensure that you have a web server (such as Apache) installed on your computer. If you don't have one, you can install a local server package like XAMPP or WAMP, which includes Apache, PHP, and MySQL.

2. Create a new directory or folder on your web server to store the program files.

3. Copy all the PHP files mentioned in the README (including `createDatabase.php`, `connectMySQL.php`,  `movies.php`, `updateMovie.php`, `deleteMovie.php`, and any other PHP files you have added) into the newly created directory.

4. Import the database:
   - Create a new MySQL database with a suitable name.

5. Update the `connectMySQL.php` file with the correct database credentials. Modify the following lines according to your MySQL configuration:
   ```php
   $host = 'localhost';
   $data = 'your_database_name';
   $user = 'your_username';
   $pass = 'your_password';
   $chrs = 'utf8mb4';
6. Open your web browser and enter the following URL in the address bar: http://localhost/movies.php.

If everything is set up correctly, the movies.php page should load in your web browser. You should be able to view and interact with the movie information displayed on the page.

