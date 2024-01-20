<?php
session_start();
?>
<?php include("connection.php"); ?>
<html>
<head>
    <title>Records</title>
    <style>
        body {
            background: radial-gradient(circle, rgb(177, 220, 108) 6%, rgba(255, 49, 135, 0.99) 100%);
        }

        table {
            background-color: whitesmoke;
        }
        .update, .delete
       {
           background-color: green;
           color: white;
           border: 0;
           outline: none;
           border-radius: 5px;
           height: 23px;
           width: 90px;
           font-weight: bold;
           cursor: pointer;
       }
       .delete
       {
           background-color: red;
       }
    </style>
</head>

<?php
include("connection.php");
error_reporting(0);

$userprofile = $_SESSION['user_name'];
if($userprofile == true)
{

}
else
{
    header('location:login.php');
}

$query = "SELECT * FROM form";
$data = mysqli_query($conn, $query);

$total = mysqli_num_rows($data);


echo $result['fname'] . " " . $result['age'] . " " . $result['email'] . " " . $result['weight'] . " " . $result['gender'] . " " . $result['record'];

//echo $total;

if ($total != 0) {
?>
    <h2 align="center">All Records</h2>
    <center>
        <table border="1" cellspacing="7" width="100%">
            <tr>
                <th width="5%">ID</th>
                <th width="10%">Full Name</th>
                <th width="3%">Age</th>
                <th width="20%">Email ID</th>
                <th width="5%">Weight</th>
                <th width="13%">Gender</th>
                <th width="25%">Record</th>
                <th width="15%">Operations</th>
            </tr>



        <?php
        while ($result = mysqli_fetch_assoc($data)) {
            echo "<tr>
                  <td>" . $result['ID'] . "</td>
                  <td>" . $result['fname'] . "</td>
                  <td>" . $result['age'] . "</td>
                  <td>" . $result['email'] . "</td>
                  <td>" . $result['weight'] . "</td>
                  <td>" . $result['gender'] . "</td>
                  <td>" . $result['record'] . "</td>

                  <td>
                  <a href= 'update_design.php?id=$result[ID]'><input
                  type='submit' value='Update' class='update'></a>
                  &nbsp &nbsp
                  <a href='delete.php?id=$result[ID]'><input type='submit'
                  value='Delete' class='delete' onclick = 'return checkdelete()'></a>
                  </td>
              </tr>
              ";
        }
    } else {
        echo "No record found";
    }
        ?>
        </table>
    </center>

<a href="logout.php"><input type="submit" name="" value="LogOut" style=
"background: blue; color: white; height: 35px; width: 100px; margin-top
: 20px; font-size: 18px; border: 0; border-radius: 5px; cursor:
pointer;"></a>

<script>
function checkdelete()
{
return confirm('Are you sure your want to delete this record?');
}
</script>