<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "exam_planning_system";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" type="text/css" href="../styles/secretary_page.css">
</head>
<body>
    <div class="container">
        <h1>Forgot Password</h1>
        <form method="POST" action="">
            <input type="text" name="emp_username" id="emp_username" placeholder="Enter Username" required><br><br>
            <input type="email" name="emp_email" id="emp_email" placeholder="Enter Email" required><br><br>
            <input type='password' name='new_password' id='new_password' placeholder='Enter New Password' required><br><br>
            
            <button type="submit">Reset Password</button>
        </form>
    
        <?php
            if (isset($_POST['emp_username']) && isset($_POST['emp_email']) && isset($_POST['new_password'])){

                $emp_username = $_POST['emp_username'];
                $emp_email = $_POST['emp_email'];
                $new_password = $_POST['new_password'];

                $sql = "SELECT * FROM employees WHERE emp_username = '$emp_username' AND emp_email = '$emp_email'";
                $result = mysqli_query($conn, $sql) or die("11");

                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_assoc($result);

                    $new_password = $_POST['new_password'];
                    
                    $sql_update = "UPDATE employees SET emp_password = '$new_password' WHERE emp_email = '$emp_email'";
                    $result_update = mysqli_query($conn, $sql_update) or die("12");

                    if ($result_update) {
                        echo "<br><br><p>Your new password is: ". $new_password . "</p>";
                    }

                } 
                else {
                    echo "<br><br><p>Username or email is incorrect.</p>";
                }
            }

            echo "<br><br><a href='../html/login.html'>Click here to go back to the login page.</a>";

            mysqli_close($conn);
        ?>
    </div>

</body>
</html>