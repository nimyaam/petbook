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
    
    if ($acc_type == 'public') {
        // Fetch registered pet IDs for the logged-in user
        $pet_query = "SELECT Pet_Id FROM pet_profile WHERE User_Id = '$User_Id'";
        $pet_result = mysqli_query($conn, $pet_query);

        // Fetch registered doctor IDs
        $doctor_query = "SELECT Doctor_Id FROM doctor_register";
        $doctor_result = mysqli_query($conn, $doctor_query);

        // Check if form is submitted
        if (isset($_POST['submit'])) {
            // Retrieve form data
            $Pet_Id = $_POST['Pet_id'];
            $Doctor_Id = $_POST['Dotor_Id'];
            $Comment = $_POST['Comment'];
            $Rating = $_POST['rating'];

            // SQL query to insert data into database
            $sql = "INSERT INTO feedback (User_Id, Pet_Id, Doctor_Id, Comment, Rating)
                    VALUES ('$User_Id', '$Pet_Id', '$Doctor_Id', '$Comment', '$Rating')";

            if (mysqli_query($conn, $sql)) {
                echo "Successfully added your feedback";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
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
<link rel="stylesheet" href="Assets/style/public_feedback.css">
</head>
<body>
<div class="container">
    <img src="Assets/images/logo.jpg" alt="Logo" class="logo-img">
    <h2>Feedback</h2>
    <form id="feedback-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-group">
            <label for="Pet_id">Pet ID:</label>
            <select id="Pet_id" name="Pet_id" required>
                <option value="">Select Pet ID</option>
                <?php while ($row = mysqli_fetch_assoc($pet_result)) { ?>
                    <option value="<?php echo $row['Pet_Id']; ?>"><?php echo $row['Pet_Id']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="Dotor_Id">Doctor ID:</label>
            <select id="Dotor_Id" name="Dotor_Id" required>
                <option value="">Select Doctor ID</option>
                <?php while ($row = mysqli_fetch_assoc($doctor_result)) { ?>
                    <option value="<?php echo $row['Doctor_Id']; ?>"><?php echo $row['Doctor_Id']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="Comment">Comment:</label>
            <textarea id="Comment" name="Comment" rows="4" required></textarea>
        </div>
        <div class="form-group">
            <label for="Rating">Rating:</label>
            <div class="rating">
                <input type="radio" id="star5" name="rating" value="5" required>
                <label for="star5">&#9733;</label>
                <input type="radio" id="star4" name="rating" value="4">
                <label for="star4">&#9733;</label>
                <input type="radio" id="star3" name="rating" value="3">
                <label for="star3">&#9733;</label>
                <input type="radio" id="star2" name="rating" value="2">
                <label for="star2">&#9733;</label>
                <input type="radio" id="star1" name="rating" value="1">
                <label for="star1">&#9733;</label>
            </div>
        </div>
        <div class="btn-container">
            <button type="button" class="back-btn" onclick="window.location.href='public_home'">Back</button>
            <button type="submit" class="submit-btn" name="submit">Submit</button>
        </div>
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
