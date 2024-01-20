<?php include("connection.php"); ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $fname = $_POST['fname'] ?? '';
    $age = $_POST['age'] ?? '';
    $email = $_POST['email'] ?? '';
    $weight = $_POST['weight'] ?? '';
    $gender = $_POST['gender'] ?? '';

    // Handle file upload
    $record = $_FILES['pdf'] ?? null;

    // Check if all required form fields are present
    if (!empty($fname) && !empty($age) && !empty($email) && !empty($weight) && !empty($gender) && $record) {
        // File details
        $filename = $record['name'];
        $filetmp = $record['tmp_name'];
        $filesize = $record['size'];
        $filetype = $record['type'];

        // Define the target directory and file path to store the uploaded file
        $targetDir = 'uploads/'; // Update with your desired directory
        $targetPath = $targetDir . $filename;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($filetmp, $targetPath)) {
            // File upload successful
            // Store the file information in the database
            include("connection.php");

            // Prepare the SQL query
            $query = "INSERT INTO form (fname, age, email, weight, gender, record) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);

            // Bind parameters to the prepared statement
            mysqli_stmt_bind_param($stmt, "ssssss", $fname, $age, $email, $weight, $gender, $targetPath);

            // Execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Data insertion successful
                echo "Successfully Registered";
            } else {
                // Data insertion failed
                echo "Failed to register. Please try again.";
            }

            // Close the statement
            mysqli_stmt_close($stmt);

            // Close the database connection
            mysqli_close($conn);
        } else {
            // File upload failed
            echo "Failed to upload the file";
        }
    } else {
        // Required form fields are missing
        echo "Please fill in all the required fields";
    }
}
?>