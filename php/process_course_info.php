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
    <title>Process Course Info</title>
    <link rel="stylesheet" type="text/css" href="../styles/add_exam.css">
</head>

<body>
    <?php

    if (isset($_POST['course_department']) && isset($_POST['course_term']) && isset($_POST['course_code']) && isset($_POST['course_name']) && isset($_POST['course_credits'])) {
        $department_id = $_POST['course_department'];
        $course_term = $_POST['course_term'];
        $course_code = $_POST['course_code'];
        $course_name = $_POST['course_name'];
        $course_credits = $_POST['course_credits'];

        $sql_check_code = "SELECT * FROM courses WHERE course_code = '$course_code'";
        $result_check_code = mysqli_query($conn, $sql_check_code) or die("1");
        if (mysqli_num_rows($result_check_code) > 0) {
            header("Location: ../php/add_course.php?error=101");
            exit();
        }

        $sql_check_name = "SELECT * FROM courses WHERE course_name = '$course_name'";
        $result_check_name = mysqli_query($conn, $sql_check_name) or die("2");

        if (mysqli_num_rows($result_check_name) > 0) {
            header("Location: ../php/add_course.php?error=102");
            exit();
        }

        $sql_insert_course = "INSERT INTO courses (department_id, course_name, course_code, course_credits, course_term)
                      VALUES ('$department_id', '$course_name', '$course_code', '$course_credits', '$course_term')";

        $result_insert_course = mysqli_query($conn, $sql_insert_course) or die("3");

        if ($result_insert_course) {
            $course_id = mysqli_insert_id($conn);

            if (isset($_POST['course_day_1']) && isset($_POST['course_time_1']) && isset($_POST['course_day_2']) && isset($_POST['course_time_2']) && isset($_POST['course_day_3']) && isset($_POST['course_time_3'])) {
                $course_day_1 = $_POST['course_day_1'];
                $course_time_1 = $_POST['course_time_1'];
                $course_day_2 = $_POST['course_day_2'];
                $course_time_2 = $_POST['course_time_2'];
                $course_day_3 = $_POST['course_day_3'];
                $course_time_3 = $_POST['course_time_3'];

                $sql_insert_schedule = "INSERT INTO schedule (course_id, course_day, course_time)
                                        VALUES ('$course_id', '$course_day_1', '$course_time_1'),
                                            ('$course_id', '$course_day_2', '$course_time_2'),
                                            ('$course_id', '$course_day_3', '$course_time_3')";
                $result_insert_schedule = mysqli_query($conn, $sql_insert_schedule) or die("4");
                
                if ($result_insert_schedule) {
                    mysqli_close($conn);
                    header("Location: ../php/add_course.php?success=1&course_code=" . $course_code);
                    exit();
                }
            }
            else {
                mysqli_close($conn);
                header("Location: ../php/add_course.php?error=103");
                exit();
            }
        }
        else {
            mysqli_close($conn);
            header("Location: ../php/add_course.php?error=104");
            exit();
        }
    }
    
    mysqli_close($conn);
    ?>
</body>

</html>
