<?php
session_start();
require 'conn.inc.php'; // Include database connection file
date_default_timezone_set('Asia/Calcutta');

if (isset($_SESSION['User_Id'], $_SESSION['name'], $_SESSION['Email'], $_SESSION['Phone_number'], $_SESSION['type'])) {
    $User_Id = $_SESSION['User_Id'];
    $name = $_SESSION['name'];
    $Email = $_SESSION['Email'];
    $Phone_number = $_SESSION['Phone_number'];
    $acc_type = $_SESSION['type'];

    if ($acc_type == 'doctor') {
        if (isset($_POST['submitMedicalRecords'])) {
            // Fetch Doctor_id from session
            $Doctor_id = $User_Id;
            $Pet_ID = $_POST['Pet_ID'];
            $Disease = $_POST['Disease'];
            $Symptoms = $_POST['Symptoms'];
            $Medicine = $_POST['Medicine'];
            $Advice = $_POST['Advice'];

            $sql = "INSERT INTO medical_record (doctor_id, pet_id, disease, symptom, medicine, advice)
                    VALUES ('$Doctor_id', '$Pet_ID', '$Disease', '$Symptoms', '$Medicine', '$Advice')";

            if (mysqli_query($conn, $sql)) {
                echo "<p class='success-message'>Medical records added successfully!</p>";
            } else {
                echo "<p>Error: " . $sql . "<br>" . mysqli_error($conn) . "</p>";
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
    <link rel="stylesheet" href="Assets/style/doctor_medical_details.css">
    <style>
        .success-message {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
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

    <!-- Medical Records Form -->
    <div class="container">
        <h2>Add Medical Records</h2>
        <form id="medical-records-form" action="" method="post">
            <!-- Doctor_id is fetched automatically from session -->
            <div class="form-group">
                <label for="Pet_ID">Pet ID:</label>
                <input type="text" id="Pet_ID" name="Pet_ID" required>
            </div>
            <div class="form-group">
                <label for="Disease">Disease:</label>
                <input type="text" id="Disease" name="Disease" required>
            </div>
            <div class="form-group">
                <label for="Symptoms">Symptoms:</label>
                <input type="text" id="Symptoms" name="Symptoms" required>
            </div>
            <div class="form-group">
                <label for="Medicine">Medicine:</label>
                <input type="text" id="Medicine" name="Medicine" required>
            </div>
            <div class="form-group">
                <label for="Advice">Advice:</label>
                <input type="text" id="Advice" name="Advice" required>
            </div>
            <button type="submit" name="submitMedicalRecords">Add Details</button>
        </form>
        <!-- Display success message -->
        <?php if (isset($successMessage)) : ?>
            <p class="success-message"><?php echo $successMessage; ?></p>
        <?php endif; ?>
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
