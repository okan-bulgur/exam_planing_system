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
        echo "<title>Head of Department " . $_SESSION['emp_name'] . " " . $_SESSION['emp_surname'] . "</title>"
    ?>
    <link rel="stylesheet" type="text/css" href="../styles/head_of_department_page.css">
</head>

<body>
    <button onclick="location.href='../php/logout.php'" class="logout-button">Log Out</button>
    <h1>Welcome <?php echo $_SESSION['emp_name'] . " " . $_SESSION['emp_surname']; ?></h1>

    <?php

    $sql_department = "SELECT * FROM emp_department WHERE emp_id = " . $_SESSION['emp_id'];
    $result_department = mysqli_query($conn, $sql_department) or die("1");
    $department_id = mysqli_fetch_assoc($result_department)['department_id'];
        
    $sql_department_name = "SELECT * FROM departments WHERE department_id = " . $department_id;
    $result_department_name = mysqli_query($conn, $sql_department_name) or die("4");
    $department_name = mysqli_fetch_assoc($result_department_name)['department_name'];

    $sql_exam = "SELECT * FROM exams INNER JOIN courses ON exams.course_id = courses.course_id WHERE department_id = ". $department_id ." ORDER BY exam_date, exam_time ASC";
    $result_exam = mysqli_query($conn, $sql_exam) or die("3");

    if (mysqli_num_rows($result_exam) > 0) {

        echo "<div style='display: flex; justify-content: space-between; align-items: center;'>";
        echo "<h2>Exam Plan (" . $department_name . ")</h2>";
        echo "<button onclick='location.reload()' class='refresh-button' >Refresh</button>";
        echo "</div>";
        
        echo "<table solid black;'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th solid black;'>Course Code</th>";
        echo "<th solid black;'>Course Name</th>";
        echo "<th solid black;'>Exam Date</th>";
        echo "<th solid black;'>Exam Time</th>";
        echo "<th solid black;'>Number of Classes</th>";
        echo "<th solid black;'>Count of Asistants</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        if (mysqli_num_rows($result_exam) > 0) {
            while ($exam_row = mysqli_fetch_assoc($result_exam)) {
                echo "<tr>";
                echo "<td solid black;'>" . $exam_row['course_code'] . "</td>";
                echo "<td solid black;'>" . $exam_row['course_name'] . "</td>";
                echo "<td solid black;'>" . $exam_row['exam_date'] . "</td>";
                echo "<td solid black;'>" . $exam_row['exam_time'] . "</td>";
                echo "<td solid black;'>" . $exam_row['number_of_classes'] . "</td>";
                echo "<td solid black;'>" . $exam_row['count_of_assistants'] . "</td>";
                echo "</tr>";
            }
        }

        echo "</tbody>";
        echo "</table>";
        
    }
    mysqli_close($conn);
    ?>
    <button onclick="location.href = '../php/assistants_scores_for_head.php';" class='score-button'>View Assistants Scores</button>

</body>

</html>
