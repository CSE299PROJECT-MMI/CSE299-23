<?php
session_start();

// Check if the user is logged in and is a doctor
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header("Location: ../Create an Account/login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "hospital_management");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_SESSION['user_id'];
$date = $_POST['date'];
$start_time = $_POST['start_time'];
$end_time = $_POST['end_time'];

// Insert new availability slot
$insert_sql = "INSERT INTO availability_slots (doctor_email, date, start_time, end_time, status) 
               VALUES (?, ?, ?, ?, 'available')";
$stmt = $conn->prepare($insert_sql);
$stmt->bind_param("ssss", $email, $date, $start_time, $end_time);
$stmt->execute();

$stmt->close();
$conn->close();

header("Location: availability.php");
exit();
?>
