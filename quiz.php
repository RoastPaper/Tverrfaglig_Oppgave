<?php
// home.php – side for innloggede brukere
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header('Location: index.html');
  exit;
}
// For å ikke vise private informasjon
require_once('/var/www/config.php');

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
$title = trim($_POST['title']);
$description = trim($_POST['description']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quiz Making</title>
  <link rel="stylesheet" href="style.css">
  <script>
  </script>
</head>
<body>
  <div class="quiz-form">
    <h1>Create Your Quiz</h1>
    <form action="quiz.php" method="post" autocomplete="off">
      <label for="title">Quiz Title:</label>
      <input type="text" id="title" name="title" required>
      <br><br>
      
      <label for="description">Description:</label>
      <textarea id="description" name="description" rows="5" cols="40"></textarea>
      <br><br>
      
      <div id="questionsContainer"></div>
      
      <button type="button" id="addQuestionButton">Add Question</button>
      <br><br>
      
      <input type="submit" value="Create Quiz">
    </form>
  </div>
  <script src="script.js"></script>
</body>
</html>