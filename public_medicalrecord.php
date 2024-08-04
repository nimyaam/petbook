<?php
session_start();
require 'conn.inc.php';
date_default_timezone_set('Asia/Calcutta'); 

if(isset($_SESSION['User_Id'], $_SESSION['name'], $_SESSION['Email'], $_SESSION['Phone_number'], $_SESSION['type'], $_SESSION['Approved'])) {
    $User_Id = $_SESSION['User_Id'];
    $name = $_SESSION['name'];
    $Email = $_SESSION['Email'];
    $Phone_number = $_SESSION['Phone_number'];
    $acc_type = $_SESSION['type'];
    $Approved = $_SESSION['Approved'];

    if($acc_type == 'public') { 
        if(isset($_POST['submitPetId'])) {
            $Pet_ID = $_POST['Pet_ID'];
            // Retrieve medical records for the specified pet ID from the database
            $sql = "SELECT * FROM medical_record WHERE pet_id = '$Pet_ID'";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0) {
                // Display medical records
                echo "<h2>Medical Records for Pet ID: $Pet_ID</h2>";
                echo "<div class='table-container'>";
                echo "<table border='1'>
                      <tr>
                        <th>Doctor ID</th>
                        <th>Disease</th>
                        <th>Symptoms</th>
                        <th>Medicine</th>
                        <th>Advice</th>
                      </tr>";
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['doctor_id'] . "</td>";
                    echo "<td>" . $row['disease'] . "</td>";
                    echo "<td>" . $row['symptom'] . "</td>";
                    echo "<td>" . $row['medicine'] . "</td>";
                    echo "<td>" . $row['advice'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
                echo "</div>";
            } else {
                echo "<h2>No medical records found for Pet ID: $Pet_ID</h2>";
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
    <link rel="stylesheet" href="Assets/style/public_medicalrecord.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        nav {
            background-color: white;
            color: black;
            padding: 10px 20px;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }
        .table-container {
            margin-top: 50px; /* Adjust based on your navigation bar's height */
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #45a049;
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 140px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropbtn {
            color: black;
            padding: 16px;
            font-size: 18px;
            border: none;
            cursor: pointer;
        }

        .dropbtn:hover, .dropbtn:focus {
            background-color: #3e8e41;
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
            <li><a href="public_home">Home</a></li>
            <li class="dropdown">
                <a href="#" class="dropbtn">Pet Registration <i class="fa fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="public_account">Pet Account</a>
                    <a href="pet_register">Pet Registration</a>
                </div>
            </li>  
            <li><a href="public_service">Services</a></li>
            <li><a href="public_medicalrecord">Medical Records</a></li>
            <li><a href="public_feedback">Feedback</a></li>
            <li><a href="logout" id="login-link">Logout</a></li>
        </ul>
    </nav>

    <!-- View Medical Records Form -->
    <div class="container">
        <h2>View Medical Records</h2>
        <form id="view-medical-records-form" action="" method="post">
            <div class="form-group">
            <label for="Pet_ID">Select Pet ID:</label>
                <select id="Pet_ID" name="Pet_ID" required>
                    <option value="">Select Pet ID</option>
                    <?php 
                        // Fetch registered pets for the current user
                        $pet_query = "SELECT Pet_Id FROM pet_profile WHERE User_Id = '$User_Id'";
                        $pet_result = mysqli_query($conn, $pet_query);
                        while ($row = mysqli_fetch_assoc($pet_result)) { 
                            echo "<option value='" . $row['Pet_Id'] . "'>" . $row['Pet_Id'] . "</option>";
                        }
                    ?>
                </select>
            </div>
            <button type="submit" name="submitPetId">View Medical Records</button>
        </form>
    </div>

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
