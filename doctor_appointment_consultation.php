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
        // Fetch appointments for this doctor
        $Doctor_Id = $User_Id;
        $sql = "SELECT pa.Pet_Id, pp.User_Id, pa.Appointment_Date, pa.Appointment_Time, pa.approve, pa.SI
                FROM public_appointment pa
                INNER JOIN pet_profile pp ON pa.Pet_Id = pp.Pet_Id
                WHERE pa.Doctor_Id = '$Doctor_Id'";
        $result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PETBOOK</title>
    <link rel="icon" type="image/x-icon" href="Assets/images/logo.jpg">
    <!-- Add Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-mXcFXAl6N3Q+9MphIIG4QmP8p6gDRqufnd/j56rYdf7hk0jGt9d7A3/6nqXe9qicb/wIyZZs9ZDb5LP0V7gKdA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="Assets/style/public_notification.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        table tbody tr:hover {
            background-color: #f5f5f5;
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
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Pet ID</th>
                    <th>Appointment Date</th>
                    <th>Appointment Time</th>
                    <th>Approval</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['User_Id']; ?></td>
                        <td><?php echo $row['Pet_Id']; ?></td>
                        <td><?php echo $row['Appointment_Date']; ?></td>
                        <td><?php echo $row['Appointment_Time']; ?></td>
                        <td><?php echo $row['approve'] ? 'Approved' : 'Pending'; ?></td>
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="appointment_id" value="<?php echo $row['SI']; ?>">
                                <?php if (!$row['approve']) { ?>
                                    <button type="submit" name="approve" value="1">Approve</button>
                                <?php } else { ?>
                                    <button type="submit" name="approve" value="0">Cancel</button>
                                <?php } ?>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php
        // Handle approve/cancel request
        if (isset($_POST['approve'])) {
            $appointment_id = $_POST['appointment_id'];
            $approve_value = $_POST['approve'];
            $sql_update = "UPDATE public_appointment SET approve = '$approve_value' WHERE SI = '$appointment_id'";
            if (mysqli_query($conn, $sql_update)) {
                echo "Appointment status updated successfully!";
                // Refresh page after updating status
                echo "<meta http-equiv='refresh' content='0'>";
            } else {
                echo "Error updating appointment status: " . mysqli_error($conn);
            }
        }
    } else {
        header("Location: logout.php");
    }
} else {
    header("Location: logout.php");
}
?>
