<?php
session_start();

if (!isset($_SESSION['emp_username'])) {
    header("Location: ../html/login.html"); // Replace with the login page URL
    exit();
}

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
    <?php
        echo "<title>Secretary " . $_SESSION['emp_name'] . " " . $_SESSION['emp_surname'] . "</title>"
    ?>
    <link rel="stylesheet" type="text/css" href="../styles/secretary_page.css">
</head>

<body>
    <button onclick="location.href='../php/logout.php'" class="logout-button">Log Out</button>

    <div class="container">
        <h1>Welcome <?php echo $_SESSION['emp_name'] . " " . $_SESSION['emp_surname']; ?></h1>

        <button onclick="location.href = '../php/add_exam.php';">Add New Exam</button><br><br>
        <button onclick="location.href = '../php/assistants_scores.php';">View Assistants Scores</button>
        
        <?php
            if (isset($_GET['error'])) {
                if ($_GET['error'] == 101) {
                    echo "<script>alert('No assistants found.');</script>";
                }
            }
        ?>
    </div>


</body>

</html>
