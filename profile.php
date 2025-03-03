<?php
session_start();

// Sjekker om brukeren er logget inn hvis brukeren er ikke sender til hjemsiden som er logget ut.
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
// Dette gjeler her også som jeg forkalrte i login.php.
require_once('/var/www/config.php');
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// SQL-spørringer for password, email, date fra accounts ved å bruke id til kontoen i table.
$stmt = $con->prepare('SELECT password, email, username, date FROM accounts WHERE id = ?');
// SQL-spørringer for title fra quiz.
// $stmt = $con->prepare('SELECT title FROM quiz WHERE id = ?'); Denne koden fungerer ikke grunn av jeg ble ikke ferdig med koden i quiz.php. 

// HEr finner det frem informasjon fra table fra toppen. Binder det sammen og finner det frem for at dek viser frem i HTML documentet.
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email, $birthdate, $username); // $title skal også være i det, men fungerer grunn av ble ikke ferdig med quiz.php.
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

      <!-- Her bruker de som jeg bindet i php. Dette viser frem i nettsiden. -->
      <table>
        <tr>
          <td>Username:</td>
          <td><?=htmlspecialchars($username, ENT_QUOTES)?></td>
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