<?php
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "hospital_management");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get feedback ID
$feedback_id = intval($_GET['feedback_id']);

// Approve feedback
$sql = "UPDATE feedback SET approved = 1 WHERE feedback_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $feedback_id);

if ($stmt->execute()) {
    echo "Feedback approved successfully!";
} else {
    echo "Error approving feedback: " . $conn->error;
}

$stmt->close();
$conn->close();

header("Location: feedback_list.php");
exit();
?>
