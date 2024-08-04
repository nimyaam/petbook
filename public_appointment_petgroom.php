<?php
session_start();
require 'conn.inc.php'; // Include database connection file
date_default_timezone_set('Asia/Calcutta');

// Function to check if a specific time slot is available for a specific staff on a specific date
function isTimeSlotAvailableForStaff($conn, $date, $time, $staff) {
    $sql = "SELECT * FROM pet_grooming WHERE Grooming_Date = '$date' AND Grooming_Time = '$time' AND staff = '$staff'";
    $result = mysqli_query($conn, $sql);
    return mysqli_num_rows($result) == 0; // Return true if no rows found, indicating the slot is available for the staff
}

// Function to check if a date is valid (not past)
function isValidDate($date) {
    $today = date("Y-m-d");
    return $date >= $today;
}

if (isset($_SESSION['User_Id'], $_SESSION['name'], $_SESSION['Email'], $_SESSION['Phone_number'], $_SESSION['type'], $_SESSION['Approved'])) {
    $User_Id = $_SESSION['User_Id'];
    $name = $_SESSION['name'];
    $Email = $_SESSION['Email'];
    $Phone_number = $_SESSION['Phone_number'];
    $acc_type = $_SESSION['type'];
    $Approved = $_SESSION['Approved'];

    if ($acc_type == 'public') {
        // Fetch staff members from the database
        $staff_query = "SELECT * FROM public_register WHERE type = 'staff'";
        $staff_result = mysqli_query($conn, $staff_query);

        // Check if form is submitted
        if (isset($_POST['submit'])) {
            // Retrieve form data
            $Pet_id = mysqli_real_escape_string($conn, $_POST['Pet_Id']); 
            $category = mysqli_real_escape_string($conn, $_POST['Category']); 
            $staff = mysqli_real_escape_string($conn, $_POST['staff']);
            $Grooming_Date = mysqli_real_escape_string($conn, $_POST['Grooming_date']); 
            $Grooming_Time = mysqli_real_escape_string($conn, $_POST['Grooming_time']);

            // Check if the selected time slot is available for the selected staff
            if (!isTimeSlotAvailableForStaff($conn, $Grooming_Date, $Grooming_Time, $staff)) {
                echo "The selected time slot for this staff is not available. Please choose another time.";
            } elseif (!isValidDate($Grooming_Date)) {
                echo "Invalid date. Please select a date equal to or after today.";
            } else {
                // SQL query to insert data into database
                $sql = "INSERT INTO pet_grooming (Pet_Id, User_Id, category, staff, Grooming_Date, Grooming_Time)
                        VALUES ('$Pet_id', '$User_Id', '$category', '$staff',  '$Grooming_Date', '$Grooming_Time')";

                if (mysqli_query($conn, $sql)) {
                    echo "Appointment booked successfully.";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="Assets/style/public_appointment_petgroom.css">
<style>
  /* Add any additional styles here */
</style>
</head>
<body>
<div class="container">
<img src="Assets/images/logo.jpg" alt="Logo" class="logo-img">
  <h2> Appointment for Grooming</h2>
  <form id="registration-form" method="post" action="public_appointment_petgroom.php">
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
      <label for="Category">Category:</label>
      <select id="Category" name="Category" required>
        <option value="">Select Type</option>
        <option value="dog">Dog</option>
         <option value="cat">Cat</option>
      </select>
    </div>
    <div class="form-group">
      <label for="staff">Staff:</label>
      <select id="staff" name="staff" required>
        <option value="">Select Staff</option>
        <?php
            while ($staff_row = mysqli_fetch_assoc($staff_result)) {
                echo "<option value=\"{$staff_row['User_Id']}\">{$staff_row['name']}</option>";
            }
        ?>
      </select>
    </div>
    
    <div class="form-group">
      <label for="Grooming_date">Grooming Date:</label>
      <input type="date" id="Grooming_date" name="Grooming_date" required>
      <i class="far fa-calendar-alt"></i>
    </div>
    <div class="form-group">
      <label for="Grooming_time">Grooming Time:</label>
      <select id="Grooming_time" name="Grooming_time" required>
        <!-- Options for grooming time slots -->
        <?php
            // Define grooming time slots (change as needed)
            $start_time = strtotime("10:00");
            $end_time = strtotime("18:00");
            $interval = 60 * 120; // 1 hour interval

            while ($start_time <= $end_time) {
                $time_formatted = date("H:i", $start_time);
                echo "<option value=\"$time_formatted\">$time_formatted</option>";
                $start_time += $interval;
            }
        ?>
      </select>
      <i class="far fa-clock"></i>
    </div>
    <div class="btn-container">
      <button type="submit" name="submit" class="submit-btn">Submit</button>
    </div>
  </form>
</div>

<script>
  // JavaScript code for form submission
</script>

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
