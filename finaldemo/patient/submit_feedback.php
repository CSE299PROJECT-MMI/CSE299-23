<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "hospital_management");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $patient_name = $conn->real_escape_string($_POST['patient_name']);
    $feedback_message = $conn->real_escape_string($_POST['feedback_message']);
    $rating = intval($_POST['rating']);

    // Insert feedback into the database
    $sql = "INSERT INTO feedback (patient_name, feedback_message, rating) VALUES ('$patient_name', '$feedback_message', $rating)";
    if ($conn->query($sql) === TRUE) {
        header("Location: feedback_success.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
$conn->close();
?>
