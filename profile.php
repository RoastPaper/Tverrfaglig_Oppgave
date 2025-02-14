<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
require_once('/var/www/config.php');
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$stmt = $con->prepare('SELECT password, email, date FROM accounts WHERE id = ?');
$stmt = $con->prepare('SELECT title FROM quiz WHERE id = ?');

$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email, $birthdate, $title);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <nav>
    <div class="profileheader">
      <h1>Warhammer 40k quiz</h1>
      <div class="right">
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
      </div>
    </div>
  </nav>
  <div>
    <h2>Profile Page</h2>
    <div>
      <p>Your account details are below:</p>
      <table>
        <tr>
          <td>Username:</td>
          <td><?=htmlspecialchars($_SESSION['name'], ENT_QUOTES)?></td>
        </tr>
        <tr>
          <td>Password:</td>
          <td><?=htmlspecialchars($password, ENT_QUOTES)?></td>
        </tr>
        <tr>
          <td>Email:</td>
          <td><?=htmlspecialchars($email, ENT_QUOTES)?></td>
        </tr>
        <tr>
          <td>Birthdate:</td>
          <td><?=htmlspecialchars($birthdate, ENT_QUOTES)?></td>
        </tr>
        <tr>
          <td>Your quizs:</td>
          <td><?=htmlspecialchars($name, ENT_QUOTES)?></td>
        </tr>
      </table>
    </div>
  </div>
</body>
</html>