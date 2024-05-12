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

/*
$sql = "SELECT * FROM emp_course WHERE emp_id = " . $_SESSION['emp_id'];
$result = mysqli_query($conn,$sql) or die("12");

$course_list = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $sql_course = "SELECT * FROM courses WHERE course_id =" . $row['course_id'];
        $result_course = mysqli_query($conn, $sql_course) or die("13");
        if (mysqli_num_rows($result_course) > 0) {
            $course_row = mysqli_fetch_assoc($result_course);
            $course_list[] = $course_row;
        }
    }
} else {
    echo "No courses found.";
}
$_SESSION['course_list'] = $course_list;
*/


?>

<!DOCTYPE html>
<html>

<head>
    <?php
        echo "<title>Asistant " . $_SESSION['emp_name'] . " " . $_SESSION['emp_surname'] . "</title>"
    ?>
    <link rel="stylesheet" type="text/css" href="../styles/assistant_page.css">
</head>

<body>
    <?php
        echo "<h1> Welcome " . $_SESSION['emp_name'] . " " . $_SESSION['emp_surname'] . "</h1>";
    ?>

    <button onclick="location.href='../php/logout.php'" class="logout-button">Log Out</button>

    <h2>Course Selection</h2>

    <?php
        echo "<form method='POST' action='../php/assistant_page.php'>";

        $sql_department = "SELECT * FROM emp_department WHERE emp_id = " . $_SESSION['emp_id'];
        $result_department = mysqli_query($conn, $sql_department) or die("1");
        $department_row = mysqli_fetch_assoc($result_department);

        $sql_courses = "SELECT * FROM courses WHERE department_id = " . $department_row['department_id'];
        $result_courses = mysqli_query($conn, $sql_courses) or die("2");

        $sql_emp_course = "SELECT * FROM emp_course WHERE emp_id = " . $_SESSION['emp_id'];
        $result_emp_course = mysqli_query($conn, $sql_emp_course) or die("3");

        $emp_courses = array();
        if (mysqli_num_rows($result_emp_course) > 0) {
            while ($emp_course_row = mysqli_fetch_assoc($result_emp_course)) {
                $emp_courses[] = $emp_course_row['course_id'];
            }
        }
        
        if (mysqli_num_rows($result_courses) > 0) {
            while ($course_row = mysqli_fetch_assoc($result_courses)) {
                if (!in_array($course_row['course_id'], $emp_courses)) {
                    echo "<input type='checkbox' name='selected_courses[]' value='" . $course_row['course_id'] . "'>" . $course_row['course_code'] . "<br>";
                }
            }
        }

        echo "<br><button class='select-button' type='submit'>Select</button>";
        echo "</form>";
        
        if(isset($_POST['selected_courses'])){
            foreach($_POST['selected_courses'] as $course_id){

                $sql_courses = "SELECT * FROM emp_course WHERE emp_id = " . $_SESSION['emp_id'] . " AND course_id = " . $course_id;
                $result_courses = mysqli_query($conn, $sql_courses) or die("4");
                
                if (mysqli_num_rows($result_courses) == 0) {
                    $sql_insert = "INSERT INTO emp_course (emp_id, course_id) VALUES (" . $_SESSION['emp_id'] . ", " . $course_id . ")";
                    mysqli_query($conn, $sql_insert) or die("5");
                }
            }

            header("Location: assistant_page.php");
        }

        echo "<h2>Selected Courses:</h2>";
        echo "<ul>";
        $sql_courses = "SELECT * FROM emp_course WHERE emp_id = " . $_SESSION['emp_id'];
        $result_courses = mysqli_query($conn, $sql_courses) or die("6");
        if (mysqli_num_rows($result_courses) > 0) {
            while ($course_row = mysqli_fetch_assoc($result_courses)) {
                $sql_course = "SELECT * FROM courses WHERE course_id = " . $course_row['course_id'];
                $result_course = mysqli_query($conn, $sql_course) or die("7");
                $course = mysqli_fetch_assoc($result_course);
                echo "<li>" . $course['course_code'] . "</li>";
            }
        }
        echo "</ul>";


        $week = isset($_GET['week']) ? $_GET['week'] : date('W');

        echo "<div class='week-plan'>";
        echo "<h2>Weekly Plan (Week: " . $week . ")</h2>";
        echo "<button onclick='location.reload()' class='refresh-button'>Refresh</button>";
        echo "</div>";
        
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Hour</th>";
        echo "<th>Monday ( ". date('d-m-Y', strtotime(date('Y') . 'W' . $week . '1')) ." )</th>";
        echo "<th>Tuesday ( ". date('d-m-Y', strtotime(date('Y') . 'W' . $week . '2')) ." )</th>";
        echo "<th>Wednesday ( ". date('d-m-Y', strtotime(date('Y') . 'W' . $week . '3')) ." )</th>";
        echo "<th>Thursday ( ". date('d-m-Y', strtotime(date('Y') . 'W' . $week . '4')) ." )</th>";
        echo "<th>Friday ( ". date('d-m-Y', strtotime(date('Y') . 'W' . $week . '5')) ." )</th>";
        echo "<th>Saturday ( ". date('d-m-Y', strtotime(date('Y') . 'W' . $week . '6')) ." )</th>";
        echo "<th>Sunday ( ". date('d-m-Y', strtotime(date('Y') . 'W' . $week . '7')) ." )</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        $hours = array("09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00");

        $sql_emp_course = "SELECT * FROM emp_course WHERE emp_id = " . $_SESSION['emp_id'];
        $result_emp_course = mysqli_query($conn, $sql_emp_course) or die("3");
        $emp_courses = array();

        if (mysqli_num_rows($result_emp_course) > 0) {
            while ($emp_course_row = mysqli_fetch_assoc($result_emp_course)) {
                $emp_courses[] = $emp_course_row['course_id'];
            }
        }

        $sql_deneme = "SELECT * FROM exams WHERE ";

        foreach ($hours as $hour) {
            echo "<tr>";
            echo "<td>" . $hour . "</td>";

            for ($i = 1; $i <= 7; $i++) {
                $check = 0;

                $courses = array();
                $day = ($i + 1)%7;
                if ($day == 0) {
                    $day = 7;
                }

                $sql_exam = "SELECT * FROM assistant_exam
                            INNER JOIN exams ON assistant_exam.exam_id = exams.exam_id
                            INNER JOIN courses ON exams.course_id = courses.course_id
                            WHERE assistant_exam.emp_id = " . $_SESSION['emp_id'] . " AND 
                            WEEK(exams.exam_date, 1) = " . $week . " AND DAYOFWEEK(exams.exam_date) = " . $day . " AND 
                            exams.exam_time = '" . $hour . "' ORDER BY exams.exam_date, exams.exam_time ASC";

                $result_exam = mysqli_query($conn, $sql_exam) or die("7");

                if (mysqli_num_rows($result_exam) > 0) {
                    $exam_row = mysqli_fetch_assoc($result_exam);
                    $courses[] = $exam_row['course_code'] . " (Exam)";
                    $check = 1;
                }

                foreach($emp_courses as $course_id){
                    $sql_schedule = "SELECT * FROM schedule WHERE course_id = " . $course_id . " AND course_day = " . $i . " AND course_time = '" . $hour . "' ORDER BY course_day, course_time ASC";
                    $result_schedule = mysqli_query($conn, $sql_schedule) or die("8");
                    if (mysqli_num_rows($result_schedule) > 0) {
                        while ($schedule_row = mysqli_fetch_assoc($result_schedule)) {
                            $sql_course = "SELECT * FROM courses WHERE course_id = " . $schedule_row['course_id'];
                            $result_course = mysqli_query($conn, $sql_course) or die("9");
                            $course_row = mysqli_fetch_assoc($result_course);
                            $courses[] = $course_row['course_code'];
                        }
                        $check = 1;
                    }
                }

                if ($check == 1){
                    echo "<td>";
                    foreach($courses as $course){
                        echo $course . "<br>";
                    }
                    echo "</td>";
                }

                if ($check == 0) {
                    echo "<td></td>";
                }
            }

            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";

        echo "<div class='navigate-week'>";
        if ($week > 1){
            echo "<button onclick='location.href=\"../php/assistant_page.php?week=" . ($week - 1) . "\"'>Previous Week</button>";
        }
        if ($week < 52){
            echo "<button onclick='location.href=\"../php/assistant_page.php?week=" . ($week + 1) . "\"'>Next Week</button>";
        }
        echo "</div>";

        mysqli_close($conn);
    ?>  

</body>

</html>
