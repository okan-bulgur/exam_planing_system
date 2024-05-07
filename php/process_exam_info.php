<?php
session_start();

if (!isset($_SESSION['emp_username'])) {
    header("Location: ../html/login.html");
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

    $sql_emp = "SELECT * FROM employees WHERE emp_role = 'assistant' ORDER BY emp_score ASC";
    $result_emp = mysqli_query($conn, $sql_emp) or die("18");

    $assistant_count = mysqli_num_rows($result_emp);
    if ($assistant_count < $num_assistants) {
        mysqli_close($conn);
        header("Location: ../php/add_exam.php?error=100");
        exit();
    }

    $sql_course = "SELECT * FROM courses WHERE course_code = '$course_code'";
    $result_course = mysqli_query($conn, $sql_course) or die("16");
    $row_course = mysqli_fetch_assoc($result_course);

    $sql_exam = "INSERT INTO exams (course_id, exam_date, exam_time, number_of_classes, count_of_assistants) VALUES ('" . $row_course['course_id'] . "', '$date', '$time', '$num_class', '$num_assistants')";
    $result_exam = mysqli_query($conn, $sql_exam) or die("17");
    $inserted_exam_id = mysqli_insert_id($conn);

    $count = 0;
    $assigned_assistants = array();
    
    if (mysqli_num_rows($result_emp) > 0) {
        while ($row_emp = mysqli_fetch_assoc($result_emp) and $count < $num_assistants) {
            $sql_assistant = "INSERT INTO assistant_exam (emp_id, exam_id) VALUES ('" . $row_emp['emp_id'] . "', '" . $inserted_exam_id . "')";
            $result_assistant = mysqli_query($conn, $sql_assistant) or die("20");
            
            $sql_score = "UPDATE employees SET emp_score = emp_score + 1 WHERE emp_id = " . $row_emp['emp_id'];
            $result_score = mysqli_query($conn, $sql_score) or die("19");

            $assigned_assistants[] = $row_emp['emp_name'] . ' ' . $row_emp['emp_surname'];
            $count = $count + 1;
        }
    }

    mysqli_close($conn);
    header("Location: ../php/add_exam.php?success=1&assigned_assistants=" . implode(",", $assigned_assistants));
    ?>
</body>

</html>
