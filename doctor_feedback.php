<?php
session_start();
require 'conn.inc.php'; // Include database connection file
date_default_timezone_set('Asia/Calcutta');

if (isset($_SESSION['User_Id'], $_SESSION['name'], $_SESSION['Email'], $_SESSION['Phone_number'], $_SESSION['type'], $_SESSION['Approved'])) {
    $User_Id = $_SESSION['User_Id'];
    $name = $_SESSION['name'];
    $Email = $_SESSION['Email'];
    $Phone_number = $_SESSION['Phone_number'];
    $acc_type = $_SESSION['type'];
    $Approved = $_SESSION['Approved'];
    
    if ($acc_type == 'doctor') {
        // Fetch feedback data for this doctor from the database
        $Doctor_Id = $_SESSION['User_Id']; // Assuming the doctor's ID is stored in 'User_Id' session variable
        $feedback_query = "SELECT * FROM feedback WHERE Doctor_Id = '$Doctor_Id'";
        $feedback_result = mysqli_query($conn, $feedback_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PETBOOK - Doctor Feedback</title>
    <link rel="icon" type="image/x-icon" href="Assets/images/logo.jpg">
    <!-- Add Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-mXcFXAl6N3Q+9MphIIG4QmP8p6gDRqufnd/j56rYdf7hk0jGt9d7A3/6nqXe9qicb/wIyZZs9ZDb5LP0V7gKdA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="Assets/style/doctor_home.css">
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
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

    <?php
    // Display feedback table if there are feedback entries
    if (mysqli_num_rows($feedback_result) > 0) {
    ?>
    <table>
        <tr>
            <th>Pet ID</th>
            <th>Comment</th>
            <th>Rating</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($feedback_result)) {
            echo "<tr>";
            echo "<td>" . $row['Pet_Id'] . "</td>";
            echo "<td>" . $row['Comment'] . "</td>";
            echo "<td>" . $row['Rating'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
    <?php
    } else {
        echo "No feedback available.";
    }
    ?>

</body>
</html>

<?php 
    } else {
        header("Location: logout"); 
    }
} else {
    header("Location: logout"); 
}
?>