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

$stmt = $con->prepare("INSERT INTO quiz (user_id, title, description) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $account_id, $title, $description);
$stmt->execute();
$quiz_id = $stmt->insert_id;
$stmt->close();

// Store question IDs to link answers
$questions = [];

foreach ($_POST as $key => $value) {
    if (preg_match('/^question(\d+)$/', $key, $matches)) {
        $question_index = $matches[1];
        $question_text = trim($value);

        if ($question_text !== "") {
            $stmt = $con->prepare("INSERT INTO questions (quiz_id, question_text) VALUES (?, ?)");
            $stmt->bind_param("is", $quiz_id, $question_text);
            $stmt->execute();
            $question_id = $stmt->insert_id;
            $stmt->close();

            // Store question ID to map with answers
            $questions[$question_index] = $question_id;
        }
    }
}

// Insert answers linked to the correct question
foreach ($_POST as $key => $value) {
    if (preg_match('/^question(\d+)_answer(\d+)$/', $key, $matches)) {
        $question_index = $matches[1]; // Extract question number
        $answer_text = trim($value);

        if ($answer_text !== "" && isset($questions[$question_index])) {
            $question_id = $questions[$question_index]; // Get corresponding question ID
            $stmt = $con->prepare("INSERT INTO answers (question_id, answers_text) VALUES (?, ?)");
            $stmt->bind_param("is", $question_id, $answer_text);
            $stmt->execute();
            $stmt->close();
        }
    }
}

echo "Quiz, questions, and answers successfully saved!";

        /*foreach ($_POST as $key => $value) {
            if (preg_match('/^answer(\d+)$/', $key, $matches)) {
                $answers_index = $matches[1];
                $answers_text = trim($value);
                if ($answer_text !== "") {
                    $stmt = $con->prepare("INSERT INTO answers (question_id, answers_text) VALUES (?, ?)");
                    $stmt->bind_param("is", $question_id, $answers_text);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        }*/
?>