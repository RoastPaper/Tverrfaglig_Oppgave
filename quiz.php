<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  header('Location: index.html');
  exit;
}
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
    <form action="save.php" method="post" autocomplete="off">
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
  <!-- Her bruker jeg javascript -->
  <script src="script.js"></script>
</body>
</html>