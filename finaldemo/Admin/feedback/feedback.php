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

// Fetch feedback data
$sql = "SELECT * FROM feedback ORDER BY date_submitted DESC";
$result = $conn->query($sql);

// Function to convert rating to stars
function ratingToStars($rating) {
    $stars = '';
    for ($i = 1; $i <= 5; $i++) {
        $stars .= $i <= $rating ? '★' : '☆';  // Filled star or empty star
    }
    return $stars;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Feedback List</title>
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #0056b3;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        a {
            text-decoration: none;
            color: #0056b3;
        }
        a:hover {
            text-decoration: underline;
        }
        .back-button {
            display: block;
            width: 200px;
            margin: 20px auto;
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

<h1>Feedback List</h1>

<?php
if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>Feedback ID</th>
                <th>Patient Name</th>
                <th>Doctor Name</th> <!-- New column -->
                <th>Feedback Message</th>
                <th>Rating</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        $rating = ratingToStars($row['rating']); // Convert rating to stars
        echo "<tr>
                <td>{$row['feedback_id']}</td>
                <td>{$row['patient_name']}</td>
                <td>{$row['doctor_name']}</td> <!-- New data -->
                <td>{$row['feedback_message']}</td>
                <td>{$rating}</td>
                <td>" . ($row['approved'] ? 'Approved' : 'Pending') . "</td>
                <td>
                    <a href='approve_feedback.php?feedback_id={$row['feedback_id']}'>Approve</a> |
                    <a href='delete_feedback.php?feedback_id={$row['feedback_id']}' 
                       onclick='return confirm(\"Are you sure you want to delete this feedback?\");'>Delete</a>
                </td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No feedback available.</p>";
}

$conn->close();
?>

<!-- Back Button -->
<a href="../admin_dashboard.php" class="back-button">Back to Dashboard</a>

</body>
</html>
