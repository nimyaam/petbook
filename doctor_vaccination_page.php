<?php
session_start();
require 'conn.inc.php'; // Include database connection file
date_default_timezone_set('Asia/Calcutta');

$successMessage = '';

if (isset($_SESSION['User_Id'], $_SESSION['name'], $_SESSION['Email'], $_SESSION['Phone_number'], $_SESSION['type'])) {
    $User_Id = $_SESSION['User_Id'];
    $name = $_SESSION['name'];
    $Email = $_SESSION['Email'];
    $Phone_number = $_SESSION['Phone_number'];
    $acc_type = $_SESSION['type'];

    if ($acc_type == 'doctor') {
        if (isset($_POST['submitVaccination'])) {
            $vaccinationType = $_POST['vaccinationType'];
            $vaccinationMessage = $_POST['vaccinationMessage'];
            $hospitalName = $_POST['hospitalName'];
            $vaccinationDate = $_POST['vaccinationDate'];
            $vaccinationTime = $_POST['vaccinationTime'];

            // Validate vaccination date (must be today or in the future)
            $today = date('Y-m-d');
            if ($vaccinationDate < $today) {
                echo "<script>alert('Please select a date equal to or after today.');</script>";
            } else {
                // Example: convert "10:00 AM - 12:00 pM" to "10:00 AM - 12:00 PM"
                // You might need to adjust this conversion based on your database schema
                if ($vaccinationTime === "10:00 AM - 12:00 pM") {
                    $vaccinationTime = "10:00 AM - 12:00 PM";
                } else if ($vaccinationTime === "2:00 AM - 4:00 PM") {
                    $vaccinationTime = "2:00 PM - 4:00 PM";
                }

                $sql = "INSERT INTO vaccination_reminder (Vaccination_type, Message, Hospital_name, Date, Time)
                        VALUES ('$vaccinationType', '$vaccinationMessage', '$hospitalName', '$vaccinationDate', '$vaccinationTime')";

                if (mysqli_query($conn, $sql)) {
                    $successMessage = "Vaccination reminder sent successfully!";
                } else {
                    echo "<p>Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
                }
            }
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PETBOOK</title>
    <link rel="icon" type="image/x-icon" href="Assets/images/logo.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-mXcFXAl6N3Q+9MphIIG4QmP8p6gDRqufnd/j56rYdf7hk0jGt9d7A3/6nqXe9qicb/wIyZZs9ZDb5LP0V7gKdA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="Assets/style/doctor_vaccination_page.css">
    <style>
        .success-message {
            color: green;
            font-weight: bold;
            animation: fadeOut 5s ease-in-out forwards;
        }

        @keyframes fadeOut {
            0% {
                opacity: 1;
            }
            100% {
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <nav>
        <div class="logo">
            <img src="Assets/images/logo.jpg" alt="Logo" class="logo-img">
            <span class="logo-text">PETBOOK</span>
        </div>
        <ul>
            <li><a href="doctor_home">Home</a></li>
            <li><a href="doctor_services">Services</a></li>
            <li><a href="doctor_medical_record">Medical Records</a></li>
            <li><a href="doctor_feedback">Feedback</a></li>
            <li><a href="logout" id="login-link">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Vaccination Reminder</h2>
        <?php if (!empty($successMessage)) : ?>
            <div class="success-message"><?php echo $successMessage; ?></div>
        <?php endif; ?>
        <form id="vaccinationForm" method="post" action="">
            <div class="form-group">
                <label for="vaccinationType">Vaccination Type:</label>
                <input type="text" id="vaccinationType" name="vaccinationType" required>
            </div>
            <div class="form-group">
                <label for="vaccinationMessage">Message:</label>
                <input type="text" id="vaccinationMessage" name="vaccinationMessage" required>
            </div>
            <div class="form-group">
                <label for="hospitalName">Hospital Name:</label>
                <input type="text" id="hospitalName" name="hospitalName" required>
            </div>
            <div class="form-group">
                <label for="vaccinationDate">Date:</label>
                <input type="date" id="vaccinationDate" name="vaccinationDate" min="<?php echo date('Y-m-d'); ?>" required>
            </div>
            <div class="form-group">
                <label for="vaccinationTime">Time:</label>
                <select id="vaccinationTime" name="vaccinationTime" required>
                    <option value="10:00 AM - 12:00 pM">10:00 AM - 12:00 PM</option>
                    <option value="2:00 AM - 4:00 PM">2:00 PM - 4:00 PM</option>
                </select>
            </div>
            <button type="submit" name="submitVaccination">Send Vaccination Reminder</button>
        </form>
    </div>
</body>
</html>

<?php
    } else {
        header("Location: logout");
        exit;
    }
} else {
    header("Location: logout");
    exit;
}
?>
