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

    if ($acc_type == 'staff') {
        // Fetch appointments for this staff member including user details
        $staff = $User_Id;
        $sql = "SELECT pg.Pet_id, pg.category, pg.Grooming_date, pg.Grooming_time, pg.approve, pg.SI, pg.message, pr.User_id, pr.Phone_number 
                FROM pet_grooming pg
                INNER JOIN public_register pr ON pg.User_id = pr.User_id
                WHERE pg.staff = '$staff'";
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
        .message-input {
            display: flex;
            align-items: center;
        }
        .message-input input[type="text"] {
            width: 70%;
            padding: 5px;
        }
        .message-input button {
            margin-left: 10px;
            padding: 5px 10px;
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
            <li><a href="staff_home.php">Home</a></li>
            <li><a href="staff_appointment_grooming.php">Appointment status</a></li>
            <li><a href="logout.php" id="login-link">Logout</a></li>
        </ul>
    </nav>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Phone Number</th>
                    <th>Pet ID</th>
                    <th>Category</th>
                    <th>Appointment Date</th>
                    <th>Appointment Time</th>
                    <th>Approval</th>
                    <th>Action</th>
                    <th>Message</th> <!-- New column header for Message -->
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['User_id']; ?></td>
                        <td><?php echo $row['Phone_number']; ?></td>
                        <td><?php echo $row['Pet_id']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><?php echo $row['Grooming_date']; ?></td>
                        <td><?php echo $row['Grooming_time']; ?></td>
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
                        <td>
                            <form method="post" action="">
                                <input type="hidden" name="appointment_id" value="<?php echo $row['SI']; ?>">
                                <div class="message-input">
                                    <input type="text" name="message" placeholder="Type your message">
                                    <button type="submit" name="send_message">Send</button>
                                </div>
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
            $sql_update = "UPDATE pet_grooming SET approve = '$approve_value' WHERE SI = '$appointment_id'";
            if (mysqli_query($conn, $sql_update)) {
                echo "Appointment status updated successfully!";
                // Refresh page after updating status
                echo "<meta http-equiv='refresh' content='0'>";
            } else {
                echo "Error updating appointment status: " . mysqli_error($conn);
            }
        }

        // Handle sending message
        if (isset($_POST['send_message'])) {
            $appointment_id = $_POST['appointment_id'];
            $message = mysqli_real_escape_string($conn, $_POST['message']);
            $sql_insert_message = "UPDATE pet_grooming SET message = '$message' WHERE SI = '$appointment_id'";
            if (mysqli_query($conn, $sql_insert_message)) {
                echo "Message sent successfully!";
                // Refresh page after sending message
                echo "<meta http-equiv='refresh' content='0'>";
            } else {
                echo "Error sending message: " . mysqli_error($conn);
            }
        }
    } else {
        header("Location: logout.php");
    }
} else {
    header("Location: logout.php");
}
?>
