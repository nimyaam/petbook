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
        // Fetch vaccination reminders
        $vaccine_sql = "SELECT * FROM vaccination_reminder";
        $vaccine_result = mysqli_query($conn, $vaccine_sql);

        // Fetch grooming appointments for the logged-in public user
        $grooming_sql = "SELECT pg.Pet_id, pg.category, pg.Grooming_date, pg.Grooming_time, pg.approve, pg.SI, pg.message, pr.Phone_number AS Staff_Phone_Number, pr.name AS Staff_Name
                        FROM pet_grooming pg
                        INNER JOIN public_register pr ON pg.staff = pr.User_Id
                        WHERE pg.User_Id = '$User_Id'";
        $grooming_result = mysqli_query($conn, $grooming_sql);

        // Fetch all appointments for this public user
        $appointment_sql = "SELECT pa.Pet_Id, pa.Doctor_Id, pa.Appointment_Date, pa.Appointment_Time, pa.approve, pa.SI
                            FROM public_appointment pa
                            WHERE pa.User_Id = '$User_Id'";
        $appointment_result = mysqli_query($conn, $appointment_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PETBOOK </title>
    <link rel="icon" type="image/x-icon" href="Assets/images/logo.jpg">
    <!-- Add Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-mXcFXAl6N3Q+9MphIIG4QmP8p6gDRqufnd/j56rYdf7hk0jGt9d7A3/6nqXe9qicb/wIyZZs9ZDb5LP0V7gKdA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="Assets/style/public_notification.css">
    <style>
        /* Additional styles for table presentation */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 0;
            font-size: 24px;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .approval-yes {
            color: green;
            font-weight: bold;
        }
        .approval-no {
            color: red;
            font-weight: bold;
        }
        /* Dropdown styles */
        .dropdown {
            position: relative;
            display: inline-block;
            margin-top: 10px;
            margin-bottom: 20px; /* Adjust as needed */
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
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
            color: blue;
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
            <li><a href="logout.php" id="login-link">Logout</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="dropdown">
            <button class="dropbtn">Select Notification</button>
            <div class="dropdown-content">
                <a href="?notification=vaccination">Vaccination Reminder</a>
                <a href="?notification=grooming">Grooming Status</a>
                <a href="?notification=consultation">Consultation Status</a>
            </div>
        </div>

        <?php
        // Handle selected notification type
        if (isset($_GET['notification'])) {
            $notification_type = $_GET['notification'];

            switch ($notification_type) {
                case 'vaccination':
                    // Display vaccination reminders
                    ?>
                    <h2 >Vaccination Reminders</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Vaccination Type</th>
                                <th>Hospital Name</th>
                                <th>Date / Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($vaccine_row = mysqli_fetch_assoc($vaccine_result)) { ?>
                                <tr>
                                    <td><?php echo $vaccine_row['Vaccination_type']; ?></td>
                                    <td><?php echo $vaccine_row['Hospital_name']; ?></td>
                                    <td><?php echo $vaccine_row['Date'] . ' / ' . $vaccine_row['Time']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php
                    break;
                case 'grooming':
                    // Display grooming status
                    ?>
                    <h2> Grooming Appointments status</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Pet ID</th>
                                <th>Category</th>
                                <th>Grooming Date</th>
                                <th>Grooming Time</th>
                                <th>Staff</th>
                                <th>Staff Phone Number</th>
                                <th>Message</th>
                                <th>Approval</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($grooming_row = mysqli_fetch_assoc($grooming_result)) { ?>
                                <tr>
                                    <td><?php echo $grooming_row['Pet_id']; ?></td>
                                    <td><?php echo $grooming_row['category']; ?></td>
                                    <td><?php echo $grooming_row['Grooming_date']; ?></td>
                                    <td><?php echo $grooming_row['Grooming_time']; ?></td>
                                    <td><?php echo $grooming_row['Staff_Name']; ?></td>
                                    <td><?php echo $grooming_row['Staff_Phone_Number']; ?></td>
                                    <td><?php echo $grooming_row['message']; ?></td>
                                    <td class="<?php echo $grooming_row['approve'] ? 'approval-yes' : 'approval-no'; ?>">
                                        <?php echo $grooming_row['approve'] ? 'Approved' : 'Pending'; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php
                    break;
                case 'consultation':
                    // Display consultation status
                    ?>
                    <h2> Consultation Appointments status</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Pet ID</th>
                                <th>Doctor ID</th>
                                <th>Appointment Date</th>
                                <th>Appointment Time</th>
                                <th>Approval</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($appointment_row = mysqli_fetch_assoc($appointment_result)) { ?>
                                <tr>
                                    <td><?php echo $appointment_row['Pet_Id']; ?></td>
                                    <td><?php echo $appointment_row['Doctor_Id']; ?></td>
                                    <td><?php echo $appointment_row['Appointment_Date']; ?></td>
                                    <td><?php echo $appointment_row['Appointment_Time']; ?></td>
                                    <td><?php echo $appointment_row['approve'] ? 'Approved' : 'Pending'; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php
                    break;
                default:
                    echo "Select a notification type.";
            }
        } else {
            echo "Select a notification type.";
        }
        ?>
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
