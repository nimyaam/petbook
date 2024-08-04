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
        if (isset($_POST['submit'])) {
            // Retrieve form data
            $Pet_Id = $_POST['Pet_Id'];
            $Category = $_POST['Category'];
            $Breed = $_POST['Breed'];
            $Age = $_POST['Age'];
            $Gender = $_POST['Gender'];
            $Weight = $_POST['Weight'];

            // Check if the provided Pet_Id already exists
            $check_query = "SELECT * FROM pet_profile WHERE Pet_Id = '$Pet_Id'";
            $check_result = mysqli_query($conn, $check_query);

            if (mysqli_num_rows($check_result) > 0) {
                echo "Sorry, Pet Id already exists. Please choose a different one.";
            } else {
                // Handle file upload
                $target_directory = "User_Uploads/Doctor/images/";
                $target_file = $target_directory . basename($_FILES["Photo"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Check if image file is a actual image or fake image
                $check = getimagesize($_FILES["Photo"]["tmp_name"]);
                if ($check === false) {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }

                // Check file size
                if ($_FILES["Photo"]["size"] > 5000000) {
                    echo "Sorry, your file is too large.";
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $uploadOk = 0;
                }

                // Move uploaded file to destination directory
                if ($uploadOk && move_uploaded_file($_FILES["Photo"]["tmp_name"], $target_file)) {
                    // Insert data into database
                    $sql = "INSERT INTO pet_profile (User_Id, Pet_Id, Category, Breed, Age, Gender, Weight, Photo) 
                            VALUES ('$User_Id', '$Pet_Id', '$Category', '$Breed', '$Age', '$Gender', '$Weight', '$target_file')";

                    if (mysqli_query($conn, $sql)) {
                        echo "Pet registered successfully!";
                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
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
<link rel="stylesheet" href="Assets/style/pet_register.css">
<style>
  /* Add any additional styles here */
</style>
</head>
<body>
<div class="container">
<img src="Assets/images/logo.jpg" alt="Logo" class="logo-img">
  <h2> Pet Registration</h2>
  <form id="registration-form" method="post" action="pet_register.php" enctype="multipart/form-data">
  <div class="form-group">
<label for="Pet_Id">Pet Id:</label>
      <input type="text" id="Pet_Id" name="Pet_Id" required>
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
      <label for="Breed">Breed:</label>
      <input type="text" id="Breed" name="Breed" required>
    </div>
    <div class="form-group">
      <label for="Age">Age:</label>
      <input type="text" id="Age" name="Age" required>
    </div>
    <div class="form-group">
      <label for="Gender">Gender:</label>
      <select id="Gender" name="Gender" required>
        <option value="">Select Type</option>
        <option value="female">female</option>
         <option value="male">male</option>
      </select>
    </div>
    <div class="form-group">
      <label for="Weight">Weight:</label>
      <input type="text" id="Weight" name="Weight" required>
    </div>
    
    <div class="form-group">
      <label for="Photo">Photo:</label>
      <input type="file" id="Photo" name="Photo" accept="image/*" onchange="previewImage()">
      <button type="button" class="upload-btn" onclick="document.getElementById('Photo').click()">Choose File</button>
      <div id="preview"></div>
    </div>
    <div class="btn-container">
      <button type="button" class="back-btn" onclick="window.location.href='public_home.php'">Back</button>
      <button type="submit" name="submit" class="submit-btn">Submit</button>
    </div>
  </form>
</div>

<script>
  // JavaScript code for image preview and form submission
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
