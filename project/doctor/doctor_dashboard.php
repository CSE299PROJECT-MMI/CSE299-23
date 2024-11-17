<?php
session_start();

// Check if the user is logged in and is a doctor
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
$sql = "SELECT first_name, last_name, phone_number, birthday, gender FROM users WHERE email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$doctor = $result->fetch_assoc();
$stmt->close();

// Retrieve today's appointments
$date = date('Y-m-d');
$appointments_sql = "SELECT p.name AS patient_name, a.start_time, a.end_time, a.status 
                     FROM appointments a 
                     JOIN patients p ON a.patient_id = p.patient_id 
                     WHERE a.doctor_email=? AND a.date=?";
$appointments_stmt = $conn->prepare($appointments_sql);
$appointments_stmt->bind_param("ss", $email, $date);
$appointments_stmt->execute();
$appointments_result = $appointments_stmt->get_result();

// Calculate total appointments (due and done)
$total_due = $total_done = 0;
while ($row = $appointments_result->fetch_assoc()) {
    if ($row['status'] === 'done') {
        $total_done++;
    } else {
        $total_due++;
    }
}
$appointments_result->data_seek(0); // Reset result pointer for further use

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="script.js"></script>
</head>
<body>
    <div class="dashboard">
        <!-- Main Content -->
        <main class="content">
            <h1>Welcome, Dr. <?php echo $doctor['first_name'] . " " . $doctor['last_name']; ?>!</h1>
            <section class="today-schedule">
                <h2>Today's Schedule</h2>
                <p><strong>Date:</strong> <?php echo $date; ?></p>
                <table>
    <caption>Appointment Patient List</caption>
    <thead>
        <tr>
            <th>Time</th>
            <th>Patient Name</th>
        </tr>
    </thead>
</table>

                    <tbody>
                        <?php while ($appointment = $appointments_result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $appointment['start_time'] . " - " . $appointment['end_time']; ?></td>
                                <td><?php echo $appointment['patient_name']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </section>
            <table border="1">
    <caption>Appointments Summary</caption>
    <thead>
        <tr>
            <th>Appointment Status</th>
            <th>Count</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Due</strong></td>
            <td><?php echo $total_due; ?></td>
        </tr>
        <tr>
            <td><strong>Done</strong></td>
            <td><?php echo $total_done; ?></td>
        </tr>
    </tbody>
</table>
           


        <!-- Right Sidebar -->
        <aside class="sidebar right">
            <!-- Profile Section -->
            <div class="profile" onclick="window.location.href='../doctor/profile/doctor_profile.php'" style="cursor: pointer;">
                <?php if (isset($doctor['gender'])): ?>
                <img src="../doctor/img/<?php echo $doctor['gender'] === 'Male' ? '../photo/male.png' : '../photo/female.png'; ?>" alt="Profile Picture">
                <?php else: ?>
                <img src="../doctor/img/default.png" alt="Profile Picture"> 
                <?php endif; ?>
                <p><?php echo $doctor['first_name'] . " " . $doctor['last_name']; ?></p>
            </div>

            <!-- Navigation Links -->
            <nav>
                <ul>
                    <li><a href="../doctor/availability/availability.php">Availability</a></li>
                    <li><a href="../doctor/appointment/appointment.php">Appointments</a></li>
                </ul>
            </nav>

            <!-- Logout Button -->
            <button onclick="logout()">Logout</button>
           
        </aside>
        

        
        

    <script>
        function logout() {
            window.location.href = '../Create an Account/logout.php';
        }
    </script>


</body>
</html>
