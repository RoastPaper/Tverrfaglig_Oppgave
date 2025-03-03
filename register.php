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

// Kobler mysql til php
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) { // Sjekker om noe feil med koblingen mellom mysql og php.
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Sjekker om brukeren har skrevt inn alle feltene rikitg.
if (!isset($username, $password, $email, $day, $month, $year)) {
    exit('Please complete the registration form!');
}
// Sjekker om det er tomt.
if (empty($username) || empty($password) || empty($email) || empty($day) || empty($month) || empty($year)) {
    exit('Please complete the registration form');
}

// Sjekker om emailen brukeren tastet er faktisk en email.
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit('Email is not valid!');
}

// Koden funksjonen preg_match for å sjekker om $username kun inneholder bokstaver som er små og store. Koden bruker en regulært uttrykk, som betyr fra start til slutt må det inneholder minst en alfanumerisk karakter.
if (preg_match('/^[a-zA-Z0-9]+$/', $username) == 0) {
    exit('Username is not valid!');
}

// Koden bruker funksjonen strlen for å sjekke hvor langt passordet er. Sjekker om det er 5 tegn eller lengre enn 20 tegn.
if (strlen($password) > 20 || strlen($password) < 5) {
    exit('Password must be between 5 and 20 characters long!');
}

// Sjekker om brukeren har put inn riktig informasjon i datoen ved å bruke funksjonen checkdate.
if (!checkdate($month, $day, $year)) {
    exit('Invalid birthdate provided!');
}

// Her bruker koden funksjonen sprintf for å lage en formatet streng som representerer en fødseldato.
$birthdate = sprintf("%04d-%02d-%02d", $year, $month, $day); // "%04d" betyr år, "%02" er måned og dag. 

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