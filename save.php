<?php
// quiz.php – processes the quiz form submission

session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: index.html');
    exit;
}

// Include your configuration with database credentials
require_once('/var/www/config.php');

// Connect to MySQL
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

// Retrieve and sanitize form input
$title = trim($_POST['title']);
$description = trim($_POST['description']);

// Get the account ID from session to link this quiz to the logged-in user
$account_id = $_SESSION['id'];  // Make sure you set this when the user logs in

// Insert the quiz into the "quizzes" table, including the account_id
$stmt = $con->prepare("INSERT INTO quiz (user_id, title, description, created_at) VALUES (?, ?, ?, NOW())");
$stmt->bind_param("ss", $user_id, $title, $description);
if (!$stmt->execute()) {
    die("Error inserting quiz: " . $stmt->error);
}
$quiz_id = $stmt->insert_id;
$stmt->close();

// Loop through POST data to find questions and corresponding answers
foreach($_POST as $key => $value) {
    // Look for keys like "question1", "question2", etc.
    if (preg_match('/^question(\d+)$/', $key, $matches)) {
?>