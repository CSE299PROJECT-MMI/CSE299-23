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

// Fetch feedback data
$sql = "SELECT * FROM feedback WHERE feedback_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $feedback_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $feedback = $result->fetch_assoc();
} else {
    die("Feedback not found.");
}

// Handle the response form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $response_message = $_POST['response_message'];

    // Update the feedback status and add response message
    $update_sql = "UPDATE feedback SET status = 'responded', response_message = ? WHERE feedback_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $response_message, $feedback_id);
    $stmt->execute();

    echo "Response submitted successfully.";
    // Redirect back to the feedback list page after successful submission
    header("Location: feedback.php");  // This redirects to feedback.php after submission
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Respond to Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f4;
            color: #333;
        }
        h1 {
            color: #0056b3;
        }
        p {
            font-size: 16px;
            margin-bottom: 10px;
        }
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #004080;
        }
        .back-button {
            display: block;
            width: 200px;
            margin: 20px auto 0;
            padding: 10px 20px;
            background-color: #d9534f;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
        }
        .back-button:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>
    <h1>Respond to Feedback</h1>
    <p><strong>Feedback from: </strong><?php echo $feedback['patient_name']; ?></p>
    <p><strong>Feedback Message: </strong><?php echo $feedback['feedback_message']; ?></p>

    <form method="POST">
        <label for="response_message">Your Response:</label><br>
        <textarea id="response_message" name="response_message" rows="4" cols="50"></textarea><br><br>
        <input type="submit" value="Submit Response">
    </form>

    <!-- Back Button -->
    <a href="feedback.php" class="back-button">Back to Feedback List</a>
</body>
</html>
