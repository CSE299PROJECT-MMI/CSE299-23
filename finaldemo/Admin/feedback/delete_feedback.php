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

// Delete feedback from the database
$delete_sql = "DELETE FROM feedback WHERE feedback_id = ?";
$stmt = $conn->prepare($delete_sql);
$stmt->bind_param("i", $feedback_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Feedback deleted successfully.";
} else {
    echo "Error deleting feedback.";
}

$stmt->close();
$conn->close();

// Redirect back to the feedback list
header("Location: feedback.php");
exit();
?>
