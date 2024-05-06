<?php
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "exam_planning_system";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} 

$emp_username = $_POST['emp_username'];
$emp_password = $_POST['emp_password'];

$sql = "SELECT * FROM employees WHERE emp_username = '$emp_username' AND emp_password = '$emp_password'";
$result = mysqli_query($conn,$sql) or die("11");

if(mysqli_num_rows($result) == 1){
    if($row = mysqli_fetch_assoc($result)){
        session_start();
        $_SESSION['emp_id'] = $row['emp_id'];
        $_SESSION['emp_username'] = $row['emp_username'];
        $_SESSION['emp_email'] = $row['emp_email'];
        $_SESSION['emp_name'] = $row['emp_name'];
        $_SESSION['emp_surname'] = $row['emp_surname'];
        $_SESSION['emp_role'] = $row['emp_role'];
    }

    if($row['emp_role'] == "assistant"){
        header("Location: ../php/assistant_page.php");

    }else if($row['emp_role'] == "secretary"){
        header("Location: ../php/secretary_page.php");
    }

}
else{
    header("Location: ../html/login.html");
}

mysqli_close($conn);

?>