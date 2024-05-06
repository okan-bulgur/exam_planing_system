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
    <title>Secretary Page</title>
    <link rel="stylesheet" type="text/css" href="../styles/add_exam.css">
</head>

<body>
    <button onclick="location.href='../php/logout.php'" class="logout-button">Log Out</button>

    <?php

    $course_code = $_POST['course_code'];
    $num_class = $_POST['num_class'];
    $num_assistants = $_POST['num_assistants'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $course_code = mysqli_real_escape_string($conn, $course_code);

    $sql_course = "SELECT * FROM courses WHERE course_code = '$course_code'";
    $result_course = mysqli_query($conn, $sql_course) or die("16");

    if (mysqli_num_rows($result_course) == 0) {
        mysqli_close($conn);
        header("Location: ../php/add_exam.php");
        exit();
    }

    $row_course = mysqli_fetch_assoc($result_course);

    $sql_exam = "INSERT INTO exams (course_id, exam_date, exam_time, number_of_classes, count_of_assistants) VALUES ('" . $row_course['course_id'] . "', '$date', '$time', '$num_class', '$num_assistants')";
    $result_exam = mysqli_query($conn, $sql_exam) or die("17");

    mysqli_close($conn);

    header("Location: ../php/add_exam.php");
    ?>
</body>

</html>
