<?php
session_start();
require 'conn.inc.php'; // Include database connection file
date_default_timezone_set('Asia/Calcutta');

// Function to check if a specific time slot for a specific doctor is available
function isTimeSlotAvailable($conn, $date, $time, $doctorId) {
    // Use prepared statements to prevent SQL injection
    $sql = "SELECT * FROM public_appointment WHERE Appointment_Date = ? AND Appointment_Time = ? AND Doctor_Id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $date, $time, $doctorId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $num_rows = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);
    return $num_rows < 5; // Return true if less than 5 rows found, indicating the slot is available
}

// Function to check if the appointment date is valid
function isAppointmentDateValid($date) {
    $today = date('Y-m-d');
    return $date >= $today; // Return true if the appointment date is today or in the future
}

if (isset($_SESSION['User_Id'], $_SESSION['name'], $_SESSION['Email'], $_SESSION['Phone_number'], $_SESSION['type'], $_SESSION['Approved'])) {
    $User_Id = $_SESSION['User_Id'];
    $name = $_SESSION['name'];
    $Email = $_SESSION['Email'];
    $Phone_number = $_SESSION['Phone_number'];
    $acc_type = $_SESSION['type'];
    $Approved = $_SESSION['Approved'];

    if ($acc_type == 'public') {
        // Check if form is submitted
        if (isset($_POST['submit'])) {
            // Retrieve and sanitize form data
            $Pet_Id = mysqli_real_escape_string($conn, $_POST['Pet_Id']);
            $Doctor_Id = mysqli_real_escape_string($conn, $_POST['Doctor_Id']);
            $Appointment_Date = mysqli_real_escape_string($conn, $_POST['Appointment_Date']);
            $Appointment_Time = mysqli_real_escape_string($conn, $_POST['Appointment_Time']);

            // Check if the appointment date is valid
            if (!isAppointmentDateValid($Appointment_Date)) {
                echo "Invalid appointment date. Please select a date on or after today.";
            } elseif (!isTimeSlotAvailable($conn, $Appointment_Date, $Appointment_Time, $Doctor_Id)) {
                // Check if the selected time slot for the selected doctor is available
                echo "The selected time slot for the selected doctor is not available. Please choose another time.";
            } else {
                // Insert the new appointment using prepared statement
                $sql_insert = "INSERT INTO public_appointment (Pet_Id, User_Id, Doctor_Id, Appointment_Date, Appointment_Time) VALUES (?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql_insert);
                mysqli_stmt_bind_param($stmt, "sssss", $Pet_Id, $User_Id, $Doctor_Id, $Appointment_Date, $Appointment_Time);

                if (mysqli_stmt_execute($stmt)) {
                    echo "Appointment booked successfully!";
                } else {
                    echo "Error: " . mysqli_error($conn);
                }

                mysqli_stmt_close($stmt);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="Assets/style/public_appointment_consultation.css">
</head>
<body>
<div class="container">
    <img src="Assets/images/logo.jpg" alt="Logo" class="logo-img">
    <h2>Appointment for Consultations</h2>
    <form id="registration-form" method="post" action="public_appointment_consultation.php">
        <div class="form-group">
            <label for="Pet_Id">Pet ID:</label>
            <select id="Pet_Id" name="Pet_Id" required>
                <option value="">Select Pet</option>

                <?php
                // Fetch pet IDs associated with the logged-in user
                $query = "SELECT Pet_Id FROM pet_profile WHERE User_Id = '$User_Id'";
                $result = mysqli_query($conn, $query);

                // Check if there are any rows returned
                if (mysqli_num_rows($result) > 0) {
                    // Output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['Pet_Id'] . "'>" . $row['Pet_Id'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No pets available</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="Doctor_Id">Doctor ID:</label>
            <select id="Doctor_Id" name="Doctor_Id" required>
                <option value="">Select Doctor</option>

                <?php
                $query = "SELECT Doctor_ID FROM doctor_register";
                $result = mysqli_query($conn, $query);

                // Check if there are any rows returned
                if (mysqli_num_rows($result) > 0) {
                    // Output data of each row
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['Doctor_ID'] . "'>" . $row['Doctor_ID'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No doctors available</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="Appointment_Date">Appointment Date:</label>
            <input type="date" id="Appointment_Date" name="Appointment_Date" required>
            <i class="far fa-calendar-alt"></i>
        </div>
        <div class="form-group">
            <label for="Appointment_Time">Appointment Time:</label>
            <select id="Appointment_Time" name="Appointment_Time" required>
                <option value="10:00 AM - 11:00 AM">10:00 AM - 11:00 AM</option>
                <option value="11:00 AM - 12:00 PM">11:00 AM - 12:00 PM</option>
                <option value="1:00 PM - 2:00 PM">1:00 PM - 2:00 PM</option>
                <option value="2:00 PM - 3:00 PM">2:00 PM - 3:00 PM</option>
                <option value="3:00 PM - 4:00 PM">3:00 PM - 4:00 PM</option>
                <option value="4:00 PM - 6:00 PM">4:00 PM - 6:00 PM</option>
                <option value="7:00 PM - 8:00 PM">7:00 PM - 8:00 PM</option>
                <!-- Add more options for other time slots -->
            </select>
        </div>
        <div class="btn-container">
            <button type="submit" name="submit" class="submit-btn">Submit</button>
        </div>
    </form>
</div>
</body>
</html>
<?php
    } else {
        header("Location: logout.php");
    }
} else {
    header("Location: logout.php");
}
?>
