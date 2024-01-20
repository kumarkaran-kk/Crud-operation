<?php
session_start();
include("connection.php");

$id = $_GET['id'];

$userprofile = $_SESSION['user_name'];
if ($userprofile == true) {

} else {
    header('location:login1.php');
}

$query = "SELECT * FROM form WHERE ID= '$id'";
$data = mysqli_query($conn, $query);
$result = mysqli_fetch_assoc($data);

// Function to safely escape values for SQL to prevent SQL injection
function escape($value) {
    global $conn;
    return mysqli_real_escape_string($conn, $value);
}

// Update user details
if (isset($_POST['update'])) {
    $fname = escape($_POST['fname']);
    $age = escape($_POST['age']);
    $email = escape($_POST['email']);
    $weight = escape($_POST['weight']);
    $gender = escape($_POST['gender']);

    $updateQuery = "UPDATE form SET fname='$fname', age='$age', email='$email', weight='$weight', gender='$gender' WHERE id='$id'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        echo "<script>alert('Data Updated')</script>";
        header("refresh:0;url=display1.php");
        exit();
    } else {
        echo "Failed to update data: " . mysqli_error($conn);
        exit();
    }
}

// Handle file upload
if (isset($_FILES['pdf']) && !empty($_FILES['pdf']['name'])) {
    $record = $_FILES['pdf'];
    $filename = escape($record['name']);
    $filetmp = $record['tmp_name'];
    $targetDir = 'uploads/';
    $targetPath = $targetDir . $filename;

    if (move_uploaded_file($filetmp, $targetPath)) {
        // Update the file path in the database
        $updateFilePathQuery = "UPDATE form SET record='$targetPath' WHERE id='$id'";
        $updateFilePathResult = mysqli_query($conn, $updateFilePathQuery);

        if (!$updateFilePathResult) {
            echo "Failed to update file path: " . mysqli_error($conn);
            exit();
        }
    } else {
        echo "Failed to upload the file.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Details</title>
    <link rel="stylesheet" href="style.css">

    <style>
        /* Add your CSS styles for the pop-up message here */
        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: 5px;
            color: #fff;
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .popup.active {
            display: flex;
        }

        .popup .close {
            position: absolute;
            top: 10px;
            right: 10px;
            color: #fff;
            font-size: 20px;
            cursor: pointer;
        }

        .popup .message {
            margin-bottom: 10px;
        }

        .popup .message a {
            color: #fff;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="title">Update Details</div>
        <div class="content">
            <form id="registrationForm" action="#" method="POST" enctype="multipart/form-data">
                <div class="user-details">
                    <div class="input-box">
                        <span class="details">Full Name</span>
                        <input type="text" name="fname" value="<?php echo $result['fname']; ?>" placeholder="Enter your name" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Age</span>
                        <input type="number" name="age" value="<?php echo $result['age']; ?>" placeholder="Enter your age" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Email Id</span>
                        <input type="email" name="email" value="<?php echo $result['email']; ?>" placeholder="Enter your email id" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Weight</span>
                        <input type="number" name="weight" value="<?php echo $result['weight']; ?>" placeholder="Enter your weight (In KG)" required>
                    </div>
                </div>
                <div class="gender-details">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender">
                        <option value="">Select</option>

                        <option value="Male" <?php if($result['gender'] == 'Male') {echo "selected";} ?>>Male</option>

                        <option value="Female" <?php if($result['gender'] == 'Female') {echo "selected";} ?>>Female</option>

                        <option value="Prefer not to say" <?php if($result['gender'] == 'Prefer not to say') {echo "selected";} ?>>Prefer not to say</option>

                    </select>
                </div>

                <div class="input-box upload">
                    <span class="details">Upload New File (if needed)</span>
                    <input type="file" name="pdf" accept=".pdf, .jpg, .jpeg, .png, .gif">
                </div>

                <div class="input-box">
                    <span class="details">Old File</span>
                    <?php
                    // Check if there's a previous file path stored in $result['record']
                    if (!empty($result['record'])) {
                        // Determine the file type based on the extension (PDF or image)
                        $fileExtension = pathinfo($result['record'], PATHINFO_EXTENSION);
                        if (in_array(strtolower($fileExtension), ['pdf', 'jpg', 'jpeg', 'png', 'gif'])) {
                            echo '<a href="' . $result['record'] . '" target="_blank">View File</a>';
                        } else {
                            echo '<span>No preview available for this file type.</span>';
                        }
                    } else {
                        echo '<span>No file uploaded yet.</span>';
                    }
                    ?>
                </div>

                <div class="button">
                    <input type="submit" name="update" value="Update">
                </div>
            </form>
        </div>
    </div>

</body>

</html>
