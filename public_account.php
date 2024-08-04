<?php
// Start session and include necessary files
session_start();
require 'conn.inc.php'; // Include database connection file
date_default_timezone_set('Asia/Calcutta');

// Check if user is logged in
if (isset($_SESSION['User_Id'], $_SESSION['name'], $_SESSION['Email'], $_SESSION['Phone_number'], $_SESSION['type'], $_SESSION['Approved'])) {
    $User_Id = $_SESSION['User_Id'];
    $name = $_SESSION['name'];
    $Email = $_SESSION['Email'];
    $Phone_number = $_SESSION['Phone_number'];
    $acc_type = $_SESSION['type'];
    $Approved = $_SESSION['Approved'];

    // Check if the account type is 'public'
    if ($acc_type == 'public') {
        // Check if form is submitted to update pet details
        if (isset($_POST['submit'])) {
            // Retrieve form data
            $Pet_Id = $_POST['Pet_Id'];
            $Category = $_POST['Category'];
            $Breed = $_POST['Breed'];
            $Age = $_POST['Age'];
            $Gender = $_POST['Gender'];
            $Weight = $_POST['Weight'];

            // Handle file upload
            if ($_FILES['Photo']['size'] > 0) {
                $target_dir = "User_Uploads/Doctor/images/"; // Directory where images will be stored
                $target_file = $target_dir . basename($_FILES["Photo"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["Photo"]["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }

                // Check file size
                if ($_FILES["Photo"]["size"] > 500000) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif") {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.";
                // if everything is ok, try to upload file
                } else {
                    // Check if the target directory exists
                    if (!file_exists($target_dir)) {
                        echo "Target directory does not exist";
                    }

                    // Check if the directory is writable
                    if (!is_writable($target_dir)) {
                        echo "Target directory is not writable";
                    }

                    // Attempt to move the uploaded file
                    if (move_uploaded_file($_FILES["Photo"]["tmp_name"], $target_file)) {
                        // File uploaded successfully, update pet details in the database
                        $sql = "UPDATE pet_profile SET Category = '$Category', Breed = '$Breed', Age = '$Age', Gender = '$Gender', Weight = '$Weight', Photo = '$target_file' WHERE Pet_Id = '$Pet_Id' AND User_Id = '$User_Id'";
                        if (mysqli_query($conn, $sql)) {
                            echo "Pet details updated successfully!";
                        } else {
                            echo "Error updating pet details: " . mysqli_error($conn);
                        }
                    } else {
                        // Print out specific error message if move_uploaded_file fails
                        echo "Sorry, there was an error uploading your file: " . $_FILES["Photo"]["error"];
                    }
                }
            } else {
                // If no new photo uploaded, update other details except the photo
                $sql = "UPDATE pet_profile SET Category = '$Category', Breed = '$Breed', Age = '$Age', Gender = '$Gender', Weight = '$Weight' WHERE Pet_Id = '$Pet_Id' AND User_Id = '$User_Id'";
                if (mysqli_query($conn, $sql)) {
                    echo "Pet details updated successfully!";
                } else {
                    echo "Error updating pet details: " . mysqli_error($conn);
                }
            }
        }

        // Fetch pet details of the logged-in user
        $fetch_query = "SELECT * FROM pet_profile WHERE User_Id = '$User_Id'";
        $fetch_result = mysqli_query($conn, $fetch_query);

        if (mysqli_num_rows($fetch_result) > 0) {
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
        font-family: Arial, sans-serif;
    }
    .container {
        max-width: 600px;
        margin: 0 auto;
        text-align: center;
    }
    h1 {
        margin-bottom: 20px;
    }
    form {
        margin-top: 20px;
        text-align: left;
    }
    .form-group {
        margin-bottom: 10px;
    }
    label {
        display: block;
        font-weight: bold;
    }
    select, input[type="text"], input[type="file"], input[type="submit"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
        margin-top: 5px;
    }
    img {
        max-width: 200px;
        max-height: 200px;
        margin-bottom: 20px;
        cursor: pointer; /* Add cursor pointer to indicate it's clickable */
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
<div class="container">
    <h1>Pet Account</h1>
    <form method="post" action="" enctype="multipart/form-data"> <!-- Add enctype for file upload -->
        <div class="form-group">
            <label for="pet_id">Select Pet Id:</label>
            <select name="Pet_Id" id="pet_id">
<?php while ($row = mysqli_fetch_assoc($fetch_result)) { ?>
    <option value="<?php echo $row['Pet_Id']; ?>" <?php if(isset($_POST['Pet_Id']) && $_POST['Pet_Id'] == $row['Pet_Id']) echo "selected"; ?>><?php echo $row['Pet_Id']; ?></option>
<?php } ?>
</select>
        </div>
        <div class="form-group">
            <input type="submit" value="View Details">
        </div>
    </form>
    <?php
    // Check if a pet is selected
    if (isset($_POST['Pet_Id'])) {
        $selected_pet_id = $_POST['Pet_Id'];
        // Fetch details of the selected pet
        $pet_query = "SELECT * FROM pet_profile WHERE Pet_Id = '$selected_pet_id' AND User_Id = '$User_Id'";
        $pet_result = mysqli_query($conn, $pet_query);
        if (mysqli_num_rows($pet_result) > 0) {
            $pet_details = mysqli_fetch_assoc($pet_result);
            // Display pet photo
            ?>
            <img src="<?php echo $pet_details['Photo']; ?>" alt="Pet Photo" id="pet_photo"> <!-- Add id for JavaScript -->
            <?php
            // Display pet details with an option to edit
            ?>
            <form method="post" action="" enctype="multipart/form-data"> <!-- Add enctype for file upload -->
                <input type="hidden" name="Pet_Id" value="<?php echo $pet_details['Pet_Id']; ?>">
                <div class="form-group">
                    <label for="Category">Category:</label>
                    <input type="text" id="Category" name="Category" value="<?php echo $pet_details['Category']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="Breed">Breed:</label>
                    <input type="text" id="Breed" name="Breed" value="<?php echo $pet_details['Breed']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="Age">Age:</label>
                    <input type="text" id="Age" name="Age" value="<?php echo $pet_details['Age']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="Gender">Gender:</label>
                    <input type="text" id="Gender" name="Gender" value="<?php echo $pet_details['Gender']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="Weight">Weight:</label>
                    <input type="text" id="Weight" name="Weight" value="<?php echo $pet_details['Weight']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="Photo">Change Photo:</label>
                    <input type="file" id="Photo" name="Photo" accept="image/*">
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Save">
                </div>
            </form>
            <?php
        } else {
            echo "Pet not found.";
        }
    }
    ?>
</div>
<script>
    // JavaScript to trigger file input click event when clicking on the photo
    document.getElementById('pet_photo').onclick = function() {
        document.getElementById('Photo').click();
    };
</script>
</body>
</html>
<?php
        } else {
            echo "No pets registered.";
        }
    } else {
        header("Location: logout.php");
    }
} else {
    header("Location: logout.php");
}
?>
