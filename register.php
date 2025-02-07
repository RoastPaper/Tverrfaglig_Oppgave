<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'william';
$DATABASE_PASS = 'Borett!06';
$DATABASE_NAME = 'websiteregister';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to the MySQL: ' . mysqli_connect_error());
}
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
    exit('Please complete the registration form!');
}
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
    exit('Please complete the registration form');
}
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username= ?')) {
    
}