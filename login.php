<?php

// Kobler til et annet fil som er ikke koblet til github. Det er viktig at du må endre dette, hvis dette skal kopieres.
require_once('/var/www/config.php');

//Her er et eksempel på hvordan du kan koble til 
//$DATABASE_HOST = 'localhost'; Koblet til datamaskinen din.
//$DATABASE_USER = 'root'; Brukeren som er koblet til databasen. 
//$DATABASE_PASS = ''; Passordet til mysql.
//$DATABASE_NAME = 'phplogin'; Navnet til databasen i mysql.

session_start();


// Her har jeg gjort at jeg lagde variabler til "$_POST['username/password'] for å forkorte ned nettsiden.
$username = trim($_POST['username']);
$password = trim($_POST['password']);

// Samme som i register.php
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Ko
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) { // Gi en SQL-spørring som henter kolonnene id og passord fra tabellen accounts fra brukernavn som samsvarer med verdien brukeren tastet inn.
    $stmt->bind_param('s', $username); // Binder variablen sammen s som angir at parameteren skal behandle som en streng
    $stmt->execute(); // Sender en SQL-spørring til databasen med bundet parametern.
    $stmt->store_result(); // Med dette for vi ikke problemer sennere når vi gjør SQL-spørringer i databasen.
    

    if ($stmt->num_rows > 0) { // Sjekker om brukernavnet finnes.
        $stmt->bind_result($id, $hashedPassword); // Knytter sammen id og hashedpassord. //
        $stmt->fetch(); // Hente den første raden fra resultatet.
        
        // Sjekker om alt er riktig som det skal ved å sjekker passord og hashedpassord. Hvis det er korrekt lage det ny sesjons-ID ved åbruke "session_regenerate_id" for å hindre sejsonsfiksering. Det lagres in i $_SESSION for at brukeren er logget inn.
        if (password_verify($password, $hashedPassword)) {
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $username;
            $_SESSION['id'] = $id;
            
            header('Location: homepage.php'); // Sender brukeren til homepage.php etter tastet inn riktig brukernavn og passord.
        } else {
            echo 'Wrong password!';
        }
    } else {
        echo 'Wrong username!';
    }
    $stmt->close();
} else {
    echo 'Could not improve SQL-sentence!';
}

$con->close();
?>