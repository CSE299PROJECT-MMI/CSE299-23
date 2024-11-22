<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f4f4;
            color: #333;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input, textarea, button {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        .back-button {
            background-color: #007bff;
            color: white;
            text-align: center;
            display: block;
            width: 100%;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
            margin-top: 15px;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
        .rating {
            display: flex;
            gap: 5px;
        }
        .star {
            font-size: 24px;
            cursor: pointer;
        }
        .star.selected {
            color: gold;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Auto-save functionality for patient name
            const patientNameInput = document.getElementById('patient_name');

            // Load saved name on page load
            const savedName = localStorage.getItem('patient_name');
            if (savedName) {
                patientNameInput.value = savedName;
            }

            // Save name to localStorage on input
            patientNameInput.addEventListener('input', () => {
                localStorage.setItem('patient_name', patientNameInput.value);
            });

            // Rating stars functionality
            const stars = document.querySelectorAll('.star');
            const ratingInput = document.getElementById('rating');

            stars.forEach((star, index) => {
                star.addEventListener('click', () => {
                    ratingInput.value = index + 1; // Update hidden rating input
                    stars.forEach((s, i) => {
                        s.classList.toggle('selected', i <= index);
                    });
                });
            });
        });
    </script>
</head>
<body>

<h1>Submit Your Feedback</h1>
<form action="submit_feedback.php" method="post">
    <label for="patient_name">Your Name</label>
    <input type="text" id="patient_name" name="patient_name" required>

    <label for="feedback_message">Your Feedback</label>
    <textarea id="feedback_message" name="feedback_message" rows="5" required></textarea>

    <label for="rating">Your Rating</label>
    <div class="rating">
        <span class="star">★</span>
        <span class="star">★</span>
        <span class="star">★</span>
        <span class="star">★</span>
        <span class="star">★</span>
    </div>
    <input type="hidden" id="rating" name="rating" required>

    <button type="submit">Submit Feedback</button>
</form>

<a href="../patient/patient_dashboard.php" class="back-button">Back to Home</a>

</body>
</html>
