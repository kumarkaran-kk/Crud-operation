<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="login-style.css">
    <title>Login</title>
</head>
<body>
    <form method="post" action="login.php">
        <div class="center">
            <h1>Login</h1>
            <div class="form">
                <input type="text" name="username" class="textfiled" placeholder="Username">
                <input type="password" name="password" class="textfiled" placeholder="Password">
                <div class="forgetpass">
                    <a href="#" class="link" onclick="message()">Forget Password ?</a>
                </div>
                <input type="submit" name="login" value="Login" class="btn"> <!-- Submit button -->
                <div class="signup"> New Member ? <a href="http://curd-operation-kk.infinityfreeapp.com/" class="link">SignUp Here</a></div>
            </div>
        </div>
    </form>

    <script>
        function message() {
            alert("Toh Password yad karo");
        }
    </script>
</body>
</html>

<?php
include("connection.php");

if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $pwd= $_POST['password'];

    $query = "SELECT * FROM form WHERE email = '$username' && fname ='$pwd' ";
    $data = mysqli_query($conn, $query);

    $total = mysqli_num_rows($data);
    //echo $total;

    if($total == 1)
    {
        $_SESSION['user_name'] = $username;
        header('location:display.php');
    }
    else
    {
        echo "Login Failed";
    }

}
?>
