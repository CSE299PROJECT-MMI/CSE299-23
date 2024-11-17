<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'doctor') {
    header("Location: ../Create an Account/login.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "hospital_management");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve doctor details
$email = $_SESSION['user_id'];
$sql = "SELECT u.email, u.first_name, u.last_name, u.phone_number, u.birthday, u.gender, 
               d.profile_picture, d.school, d.college, d.medical_college, d.other_degrees, 
               d.father_name, d.mother_name, d.address, d.specialties
        FROM users u
        LEFT JOIN doctor_edu d ON u.id = d.user_id
        WHERE u.email = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$doctor = $result->fetch_assoc();
$stmt->close();
$conn->close();

// Assign defaults for missing fields
$profilePicture = $doctor['profile_picture'] ?? ($doctor['gender'] === 'Male' ? 'Male.png' : 'Female.png');
$firstName = $doctor['first_name'] ?? "N/A";
$lastName = $doctor['last_name'] ?? "N/A";
$email = $doctor['email'] ?? "N/A";
$phoneNumber = $doctor['phone_number'] ?? "N/A";
$birthday = $doctor['birthday'] ?? "N/A";
$gender = $doctor['gender'] ?? "N/A";
$school = $doctor['school'] ?? "Not provided";
$college = $doctor['college'] ?? "Not provided";
$medicalCollege = $doctor['medical_college'] ?? "Not provided";
$otherDegrees = $doctor['other_degrees'] ?? "N/A";
$fatherName = $doctor['father_name'] ?? "N/A";
$motherName = $doctor['mother_name'] ?? "N/A";
$address = $doctor['address'] ?? "N/A";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Profile</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="profile-container">
        <h1>Welcome to Doctor Profile</h1>
        <div class="profile">
            <div class="left-side">
                <img src="../doctor/img/<?php echo htmlspecialchars($profilePicture); ?>" alt="Profile Picture">
                <h2>Dr. <?php echo htmlspecialchars($firstName . " " . $lastName); ?></h2>
                <p><strong>Specialties:</strong> <?php echo htmlspecialchars($doctor['specialties'] ?? "Not provided"); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                <p><strong>Educations:</strong></p>
                <p><?php echo htmlspecialchars($school); ?></p>
                <p><?php echo htmlspecialchars($college); ?></p>
                <p><?php echo htmlspecialchars($medicalCollege); ?></p>
                <p><strong>Degrees:</strong></p>
                <p><em></em> <?php echo htmlspecialchars($otherDegrees); ?></p>
            </div>
            <div class="right-side">
                <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($phoneNumber); ?></p>
                <p><strong>Birthday:</strong> <?php echo htmlspecialchars($birthday); ?></p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($gender); ?></p>
                <p><strong>Father's Name:</strong> <?php echo htmlspecialchars($fatherName); ?></p>
                <p><strong>Mother's Name:</strong> <?php echo htmlspecialchars($motherName); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($address); ?></p>
            </div>
        </div>
        <div class="button_container">
            <button onclick="window.location.href='edit_profile.php'">Edit Profile</button>
            
            <button onclick="window.location.href='../doctor_dashboard.php'">Dashboard</button>
        </div>
    </div>

    

</body>
</html>
