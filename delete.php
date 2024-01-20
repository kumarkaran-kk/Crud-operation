<?php
include("connection.php");

if(isset($_GET['id'])) {
    $id = $_GET['id']; // Corrected the assignment operator
    $query = "DELETE FROM form WHERE id = $id"; // Corrected the SQL query
    $data = mysqli_query($conn, $query);
    
    if($data) {
        echo "<script>alert('Record Deleted')</script>";
        echo '<meta http-equiv="refresh" content="0; url="display1.php" />';
    } else {
        echo "<script>alert('Failed To Delete')</script>";
    }
} else {
    echo "<script>alert('Invalid ID')</script>";
}
?>
