<?php

session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.html');
    exit;
}
require_once('/var/www/config.php');

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$title = trim($_POST['title']);
$description = trim($_POST['description']);

$account_id = $_SESSION['id'];

$stmt = $con->prepare("INSERT INTO quiz (user_id, title, description, created_at) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("iss", $user_id, $title, $description);
if (!$stmt->execute()) {
    die("Error inserting quiz: " . $stmt->error);
}
$quiz_id = $stmt->insert_id;
$stmt->close();

// Her prøver det å Loope gjennom post data for å finne spørsmåler som tilsvarende svar
foreach($_POST as $key => $value) {
    // Ser etter for nøkler som "question1"
    if (preg_match('/^question(\d+)$/', $key, $matches)) {
    }}
?>