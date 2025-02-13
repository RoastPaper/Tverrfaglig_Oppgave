<?php
require_once('/var/www/config.php');

session_start();

$username = trim($_POST['username']);
$password = trim($_POST['password']);

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if (!isset($username, $password) || empty($username) || empty($password)) {
    exit('Please complete the login form!');
}

if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashedPassword);
        $stmt->fetch();
        
        if (password_verify($password, $hashedPassword)) {
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $username;
            $_SESSION['id'] = $id;
            
            header('Location: homepage.php');
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