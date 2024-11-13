<?php
session_start();

// Check if user is logged in and is a patient
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'patient') {
    header("Location:../Create an Account/login.php ");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "hospital_management");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve patient details
$email = $_SESSION['user_id'];
$sql = "SELECT first_name, last_name, phone_number, birthday, gender FROM users WHERE email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$patient = $result->fetch_assoc();

$stmt->close();
$conn->close();
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="CSS\p.css">
</head>
<body>
    <div class="container">
        <!--aside section-->
        <aside>
            <div class="top">
                <div class="logo">
                    <h2>MIS<span class="danger">CARE.</span></h2>
                </div>
                <div class="home">
                    <span class="material-symbols-outlined">home</span>
                </div>
            </div>
            <div class="sidebar">
                <a href="patient.php">
                <span class="material-symbols-outlined">grid_view</span>
                <h3>Dashboard</h3>
                </a>
                <a href="login.php" class="active">
                <span class="material-symbols-outlined">book_online</span>
                <h3>Appointments</h3>
                </a>
                <a href="#">
                    <span class="material-symbols-outlined">Medical_Information</span>
                    <h3>Report</h3>
                </a>
                <a href="#">
                    <span class="material-symbols-outlined">person</span>
                    <h3>Profile settings</h3>
                    </a>
                    <a href="../Create an Account/logout.php">
                        <span class="material-symbols-outlined">Logout</span>
                        <h3>Logout</h3>
                        </a>    

            </div>
            
        </aside>

        <!--main section-->
        <main>
            <h1>Dashboard</h1>
            

            <div class="insight">
                <div class="report">
                    <span class="material-symbols-outlined">Meeting_room</span>
                    <div class="middle">
                        <div class="left">
                            <h3>Total Session</h3>
                            <h1>12</h1>
                            <p>Session completed 1</p>
                        </div>
                        
                    </div>
                    <small>Last session 1 month  ago</small>
                </div>
                
                <div class="appointment">
                    <span class="material-symbols-outlined">event</span> <!-- Replacing with a calendar icon -->
                    <div class="middle">
                        <div class="left">
                            <h3>Upcoming Appointment</h3>
                            <h1>Dr. Mark Davis</h1> <!-- Doctor's Name -->
                            <p>Date: October 10, 2024</p> <!-- Appointment Date -->
                            <p>Time: 2:30 PM</p> <!-- Appointment Time -->
                        </div>
                        
                    </div>
                    <small>Last appointment was 1 month ago</small>
                </div>
                
                <div class="health-tips">
                    <span class="material-symbols-outlined">local_hospital</span> <!-- Health icon -->
                    <div class="middle">
                        <div class="left">
                            <h3>Health Tips</h3>
                            <p>• Stay hydrated by drinking at least 8 glasses of water a day.</p>
                            <p>• Incorporate at least 30 minutes of physical activity into your daily routine.</p>
                            <p>• Monitor your blood sugar levels regularly if you are diabetic.</p>
                            <p>• Eat a balanced diet rich in fruits, vegetables, and whole grains.</p>
                        </div>
                    </div>
                    <small>Last updated: September 29, 2024</small>
                </div>
                
            </div>

            <!--History-->
            <div class="history">
                <h1>Counseling Appointment History</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Counselor</th>
                            <th>Session Type</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Action</th> <!-- Added a header for action -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>October 20, 2024</td>
                            <td>10:00 AM</td>
                            <td>Dr. Sarah Johnson</td>
                            <td>Individual</td>
                            <td>Paid</td>
                            <td class="warning">Pending</td>
                            <td class="primary"><button>Details</button></td> <!-- Added button element -->
                        </tr>
                        <tr>
                            <td>October 10, 2024</td>
                            <td>2:30 PM</td>
                            <td>Dr. Mark Davis</td>
                            <td>Group Therapy</td>
                            <td>Due</td>
                            <td class="warning">Pending</td>
                            <td class="primary"><button>Details</button></td> <!-- Added button element -->
                        </tr>
                        <tr>
                            <td>August 28, 2024</td>
                            <td>11:45 AM</td>
                            <td>Dr. Emily Harris</td>
                            <td>Individual</td>
                            <td>Paid</td>
                            <td class="warning">Completed</td>
                            <td class="primary"><button>Details</button></td> <!-- Added button element -->
                        </tr>
                    </tbody>
                </table>
            </div>
            

                
            

            
        
            
        </main>

        <!--right section-->
        <right>
            
           <div class="top">
        <button id="menu_bar">
            <span class="material-symbols-outlined">menu</span>
        </button>
        
        <div class="theme-toggler">
            <span class="material-symbols-outlined" id="light-icon" style="display: block;">light_mode</span>
            <span class="material-symbols-outlined" id="dark-icon" style="display: none;">dark_mode</span>
        </div>
        
        <div class="profile">
            <div class="info">
                <p><b><?php echo htmlspecialchars($user['first_name']); ?></b></p> <!-- Display First Name -->
                <p>Patient</p>
                <small class="text-muted"><?php echo htmlspecialchars($user['email']); ?></small> <!-- Display Email -->
            </div>
            <div class="profile-photo">
                <img src="photo/<?php echo htmlspecialchars($user['profile_photo']); ?>" alt="Profile Photo"> <!-- Display Profile Photo -->
            </div>
        </div>
    </div>
            <!--end top-->
            <div class="recent-updates">
                <h4>Recent Updates</h4>
                <ul>
                    <li><span class="material-symbols-outlined">notifications</span> Reminder: Next appointment in 9 days</li>
                    <li><span class="material-symbols-outlined">event</span> Appointment booked with Dr. Mark Davis</li>
                    <li><span class="material-symbols-outlined">message</span> <a href="chat.html">New message from Dr. Sarah Johnson</a></li>
                </ul>
            </div>
            
            <div class="progress-summary">
                <h4>Progress Summary</h4>
                <ul>
                    <li><span class="material-symbols-outlined">check_circle</span> Completed Sessions: 1/12</li>
                    <li><span class="material-symbols-outlined">payment</span> Payments Completed: 1/3</li>
                    <li><span class="material-symbols-outlined">hourglass_empty</span> Pending Tasks: 2 Payment</li>
                </ul>
            </div>
            
            <div class="shortcuts">
                <h4>Quick Links</h4>
                <ul>

                    <li><span class="material-symbols-outlined">schedule</span> Upcoming Appointments</li>
                    <li><span class="material-symbols-outlined">payment</span> Manage Payments</li>
                    <li><span class="material-symbols-outlined">tips_and_updates</span> Health Tips</li>
                </ul>
            </div>
            
            
        </right>
    </div>
    <script src="patient.js"></script>
    
</body>