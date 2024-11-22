<?php
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Check if feedback ID is provided
if (!isset($_GET['feedback_id'])) {
    die("No feedback ID provided.");
}

$feedback_id = $_GET['feedback_id'];

// Database connection
$conn = new mysqli("localhost", "root", "", "hospital_management");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update feedback status to 'closed'
$update_sql = "UPDATE feedback SET status = 'closed' WHERE feedback_id = ?";
$stmt = $conn->prepare($update_sql);
$stmt->bind_param("i", $feedback_id);
$stmt->execute();

echo "Feedback closed successfully.";

// Redirect back to feedback.php
header("Location: feedback.php");
exit();
?>
