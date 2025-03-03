<?php
// home.php – side for innloggede brukere
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) { // Passer på at brukeren er logget inn, hvis ikke vil sende brukeren til index.html som trenger ikke være logget inn.
  header('Location: index.html'); 
  exit;
}

// HTMl document
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Warhammer 40k Quizs - Home</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <nav>
    <div class="profileheader">
      <h1>Warhammer 40k Quizs</h1>
      <div class="right">
        <a href="profile.php" class="login-btn">Profile</a>
        <a href="logout.php" class="login-btn">Logout</a>
      </div>
    </div>
  </nav>
  <header>
    <div class="header">
      <logo>
        <img src="Bilder/Warhammer-logo.png" alt="Warhammer Logo">
      </logo>
      <h1>Welcome to Warhammer 40k Quizes</h1>
    </div>
  </header>
  <article>
    <div class="explain">
      <p>In this website you will find many different types of quizes about Warhammer 40k.</p>
	  <div>
		<p>You have have logged in. Now can you make your own quizes let us begin </p>
		<a href="quiz.php">Quiz</a>
	</div>
    </div>
  </article>
</body>
</html>