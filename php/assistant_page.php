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

    <form action="course_info.php" method="post">
        <h2>Course Selection</h2>
        <select name="selected_course">
            <?php
                foreach ($course_list as $course) {
                    echo "<option value='" . $course['course_id'] . "'>" . $course['course_code'] . "</option>";
                }
            ?>
        </select>
        <input type="submit" value="Select Course">
    </form>


    <?php
        echo "<h2>Course List</h2>";
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Course Code</th>";
        echo "<th>Course Name</th>";
        echo "<th>Course Credits</th>";
        echo "<th>Course Term</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        foreach ($course_list as $course) {
            echo "<tr>";
            echo "<td>" . $course['course_code'] . "</td>";
            echo "<td>" . $course['course_name'] . "</td>";
            echo "<td>" . $course['course_credits'] . "</td>";
            echo "<td>" . $course['course_term'] . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";

        $week = isset($_GET['week']) ? $_GET['week'] : date('W');

        echo "<div class='week-plan'>";
        echo "<h2>Weekly Plan (Week: " . $week .")</h2>";
        echo "<button onclick='location.reload()' class='refresh-button'>Refresh</button>";
        echo "</div>";
        
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Course Code</th>";
        echo "<th>Exam Date</th>";
        echo "<th>Exam Time</th>";
        echo "<th>Number of Classes</th>";
        echo "<th>Count of Asistants</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        $sql_as_ex = "SELECT * FROM assistant_exam WHERE emp_id = " . $_SESSION['emp_id'];
        $result_as_ex = mysqli_query($conn, $sql_as_ex) or die("14");

        if (mysqli_num_rows($result_as_ex) > 0){
            while ($as_ex_row = mysqli_fetch_assoc($result_as_ex)) {

                $sql_exam = "SELECT * FROM exams INNER JOIN courses ON exams.course_id = courses.course_id WHERE exam_id = " . $as_ex_row['exam_id'] . " AND WEEK(exams.exam_date) = " . $week . " ORDER BY exam_date, exam_time ASC";
                $result_exam = mysqli_query($conn, $sql_exam) or die("15");

                if (mysqli_num_rows($result_exam) > 0) {
                    while ($exam_row = mysqli_fetch_assoc($result_exam)) {
                        echo "<tr>";
                        echo "<td>" . $exam_row['course_code'] . "</td>";
                        echo "<td>" . $exam_row['exam_date'] . "</td>";
                        echo "<td>" . $exam_row['exam_time'] . "</td>";
                        echo "<td>" . $exam_row['number_of_classes'] . "</td>";
                        echo "<td>" . $exam_row['count_of_assistants'] . "</td>";
                        echo "</tr>";
                    }
                }
            }
        }

        echo "</tbody>";
        echo "</table>";

        echo "<div class='navigate-week'>";
        echo "<button onclick='location.href=\"../php/assistant_page.php?week=" . ($week - 1) . "\"'>Previous Week</button>";
        echo "<button onclick='location.href=\"../php/assistant_page.php?week=" . ($week + 1) . "\"'>Next Week</button>";
        echo "</div>";

        mysqli_close($conn);
    ?>  

</body>

</html>
