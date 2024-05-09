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
    <title>Process Exam Info</title>
    <link rel="stylesheet" type="text/css" href="../styles/add_exam.css">
</head>

<body>
    <button onclick="location.href='../php/logout.php'" class="logout-button">Log Out</button>

    <?php

    function convertDay($day_int) {
        switch($day_int) {
            case 1:
                return "Monday";
            case 2:
                return "Thuesday";
            case 3:
                return "Wednesday";
            case 4:
                return "Thursday";
            case 5:
                return "Friday";
            case 6:
                return "Saturday";
            case 7:
                return "Sunday";
        }
    }

    function getDayOfWeek($date) {
        $date_parts = explode('-', $date);
        
        $year = $date_parts[0];
        $month = $date_parts[1];
        $day = $date_parts[2];
        
        $day_of_date = date('N', mktime(0, 0, 0, $month, $day, $year));
        
        return convertDay($day_of_date);
    }


    $course_code = $_POST['course_code'];
    $num_class = $_POST['num_class'];
    $num_assistants = $_POST['num_assistants'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $course_code = mysqli_real_escape_string($conn, $course_code);
    $day_of_date = getDayOfWeek($date);
    $time = date('H:i:s', strtotime($time));

    $sql_emp = "SELECT * FROM employees WHERE emp_role = 'assistant' ORDER BY emp_score ASC";
    $result_emp = mysqli_query($conn, $sql_emp) or die("1");

    $assistant_count = mysqli_num_rows($result_emp);
    if ($assistant_count < $num_assistants) {
        mysqli_close($conn);
        header("Location: ../php/add_exam.php?error=100");
        exit();
    }

    $available_assistants = array();
    
    if(mysqli_num_rows($result_emp) > 0) {
        while ($row_emp = mysqli_fetch_assoc($result_emp)) {

            $is_assistan_available = true;
            
            $sql_emp_course = "SELECT * FROM emp_course 
                                INNER JOIN courses ON emp_course.course_id = courses.course_id 
                                INNER JOIN schedule ON emp_course.course_id = schedule.course_id 
                                WHERE emp_course.emp_id = " . $row_emp['emp_id'];

            $result_emp_course = mysqli_query($conn, $sql_emp_course) or die("4");

            if(mysqli_num_rows($result_emp_course) > 0) {
                while ($row_emp_course = mysqli_fetch_assoc($result_emp_course)) {
                    $course_day = convertDay($row_emp_course['course_day']);

                    if ($row_emp_course['course_code'] == $course_code) {
                        $is_assistan_available = false;
                    }
                    else if($day_of_date == $course_day && $time == $row_emp_course['course_time']) {
                        $is_assistan_available = false;
                    }
                }
            }

            $sql_assistant_exam = "SELECT * FROM assistant_exam 
                                   INNER JOIN exams ON assistant_exam.exam_id = exams.exam_id 
                                   WHERE assistant_exam.emp_id = " . $row_emp['emp_id'];

            $result_assistant_exam = mysqli_query($conn, $sql_assistant_exam) or die("5");

            if (mysqli_num_rows($result_assistant_exam) > 0) {
                while ($row_assistant_exam = mysqli_fetch_assoc($result_assistant_exam)) {

                    if ($row_assistant_exam['exam_date'] == $date && $row_assistant_exam['exam_time'] == $time) {
                        $is_assistan_available = false;
                    }
                }
            }

            if ($is_assistan_available == true) {
                $available_assistants[] = $row_emp['emp_id'];
            }

        }
    }

    $count = 0;
    $assigned_assistants = array();


    echo "Available_assistants: <br>";

    foreach($available_assistants as $assistant) {
        echo $assistant . "<br>";
    }

    if (sizeof($available_assistants) != $num_assistants) {
        mysqli_close($conn);
        header("Location: ../php/add_exam.php?error=100");
        exit();
    }

    $sql_course = "SELECT * FROM courses WHERE course_code = '$course_code'";
    $result_course = mysqli_query($conn, $sql_course) or die("2");
    $row_course = mysqli_fetch_assoc($result_course);

    $sql_exam = "INSERT INTO exams (course_id, exam_date, exam_time, number_of_classes, count_of_assistants) VALUES ('" . $row_course['course_id'] . "', '$date', '$time', '$num_class', '$num_assistants')";
    $result_exam = mysqli_query($conn, $sql_exam) or die("3");
    $inserted_exam_id = mysqli_insert_id($conn);

    $sql_emp = "SELECT * FROM employees WHERE emp_role = 'assistant' ORDER BY emp_score ASC";
    $result_emp = mysqli_query($conn, $sql_emp) or die("1");
    
    if (mysqli_num_rows($result_emp) > 0) {
        while ($row_emp = mysqli_fetch_assoc($result_emp) and $count < $num_assistants) {

            if (in_array($row_emp['emp_id'], $available_assistants)) {
                $sql_assistant = "INSERT INTO assistant_exam (emp_id, exam_id) VALUES ('" . $row_emp['emp_id'] . "', '" . $inserted_exam_id . "')";
                $result_assistant = mysqli_query($conn, $sql_assistant) or die("6");
                
                $sql_score = "UPDATE employees SET emp_score = emp_score + 1 WHERE emp_id = " . $row_emp['emp_id'];
                $result_score = mysqli_query($conn, $sql_score) or die("7");
    
                $assigned_assistants[] = $row_emp['emp_name'] . ' ' . $row_emp['emp_surname'];
                $count = $count + 1;
            }

        }
    }

    mysqli_close($conn);
    header("Location: ../php/add_exam.php?success=1&assigned_assistants=" . implode(",", $assigned_assistants));
    ?>
</body>

</html>
