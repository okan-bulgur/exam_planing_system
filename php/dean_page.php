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

if(isset($_POST['faculty'])) {
    $selected_faculty = $_POST['faculty'];
} else {
    $selected_faculty = "";
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Dean <?php echo $_SESSION['emp_name'] . " " . $_SESSION['emp_surname']; ?></title>
    <link rel="stylesheet" type="text/css" href="../styles/dean_page.css">
</head>

<body>
    <button onclick="location.href='../php/logout.php'" class="logout-button">Log Out</button>
    
    <h1>Welcome <?php echo $_SESSION['emp_name'] . " " . $_SESSION['emp_surname']; ?></h1>
    <div class="container">

        <form id="department_form" action="" method="POST">

            <?php
            $sql_faculty = "SELECT * FROM emp_faculty WHERE emp_id = " . $_SESSION['emp_id'];
            $result_faculty = mysqli_query($conn, $sql_faculty) or die("1");
            $row_faculty = mysqli_fetch_assoc($result_faculty);

            $selected_department = isset($_POST['department']) ? $_POST['department'] : "";
            $sql_department = "SELECT * FROM departments WHERE faculty_id = " . $row_faculty['faculty_id'];
            $result_department = mysqli_query($conn, $sql_department) or die("2");

            if (mysqli_num_rows($result_department) > 0) {
                echo "<label for='department'>Select Department</label>";
                echo "<select name='department' id='department'>";

                while ($row_department = mysqli_fetch_assoc($result_department)) {
                    $selected = ($selected_department == $row_department['department_id']) ? "selected" : "";
                    echo "<option value='" . $row_department['department_id'] . "' $selected>" . $row_department['department_name'] . "</option>";
                }

                echo "</select>";
            }
            echo "<input type='submit' value='Select'>";
            ?>
        </form>
    </div>
        
    <?php
    if(isset($_POST['department'])){
        $sql_department_name = "SELECT * FROM departments WHERE department_id = " . $_POST['department'];
        $result_department_name = mysqli_query($conn, $sql_department_name) or die("4");
        $department_name = mysqli_fetch_assoc($result_department_name)['department_name'];

        $sql_exam = "SELECT * FROM exams INNER JOIN courses ON exams.course_id = courses.course_id WHERE department_id = ". $_POST['department'] ." ORDER BY exam_date, exam_time ASC";
        $result_exam = mysqli_query($conn, $sql_exam) or die("3");

        if(mysqli_num_rows($result_exam) == 0){
            echo "<h2 style='text-align: center'>No exam plan for " . $department_name . "</h2>";
        }

        if (mysqli_num_rows($result_exam) > 0) {
            echo "<div style='display: flex; justify-content: space-between; align-items: center;'>";
            echo "<h2>Exam Plan (" . $department_name . ")</h2>";
            echo "<button onclick='location.reload()' class='refresh-button' >Refresh</button>";
            echo "</div>";
            
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Course Code</th>";
            echo "<th>Course Name</th>";
            echo "<th>Exam Date</th>";
            echo "<th>Exam Time</th>";
            echo "<th>Number of Classes</th>";
            echo "<th>Count of Assistants</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            while ($exam_row = mysqli_fetch_assoc($result_exam)) {
                echo "<tr>";
                echo "<td>" . $exam_row['course_code'] . "</td>";
                echo "<td>" . $exam_row['course_name'] . "</td>";
                echo "<td>" . $exam_row['exam_date'] . "</td>";
                echo "<td>" . $exam_row['exam_time'] . "</td>";
                echo "<td>" . $exam_row['number_of_classes'] . "</td>";
                echo "<td>" . $exam_row['count_of_assistants'] . "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        }
    }

    mysqli_close($conn);
    ?>
</body>
</html>
