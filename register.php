<?php
// For å ikke vise private informasjon
require_once('/var/www/config.php');

// trim brukes for å fjerne whitespace og andre fra begge siden av stringen.
$username = trim($_POST['username']);
$password = trim($_POST['password']);
$email    = trim($_POST['email']);

// intval brukes for å gi tilbake integer verdien av variablen.
$day   = intval($_POST['day']);
$month = intval($_POST['month']);
$year  = intval($_POST['year']);

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if (!isset($username, $password, $email, $day, $month, $year)) {
    exit('Please complete the registration form!');
}
if (empty($username) || empty($password) || empty($email) || empty($day) || empty($month) || empty($year)) {
    exit('Please complete the registration form');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit('Email is not valid!');
}

if (preg_match('/^[a-zA-Z0-9]+$/', $username) == 0) {
    exit('Username is not valid!');
}

if (strlen($password) > 20 || strlen($password) < 5) {
    exit('Password must be between 5 and 20 characters long!');
}

if (!checkdate($month, $day, $year)) {
    exit('Invalid birthdate provided!');
}
$birthdate = sprintf("%04d-%02d-%02d", $year, $month, $day);

if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo 'Username exists, please choose another!';
    } else {
        if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email, date) VALUES (?, ?, ?, ?)')) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param('ssss', $username, $hashedPassword, $email, $birthdate);
            $stmt->execute();
            echo 'You have successfully registered, you can now login!';
        } else {
            echo 'Could not prepare INSERT statement!';
        }
    }
    $stmt->close();
} else {
    echo 'Could not prepare SELECT statement!';
}
$con->close();
?>

Her skal det sende informasjon om brukerens sin quiz inn i databasen for at brukeren kan beholde og vise til det andre.

Jeg har laget en javascript fil for nettsiden.