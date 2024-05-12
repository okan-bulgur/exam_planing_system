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
    <title>Add Course</title>
    <link rel="stylesheet" type="text/css" href="../styles/add_exam.css">
</head>

<body>
    <?php
    if($_SESSION['emp_role'] == "secretary") {
        echo "<button onclick=\"location.href='../php/secretary_page.php'\" class=\"back-button\">←</button>";
    }
    else if($_SESSION['emp_role'] == "head_of_secretary") {
        echo "<button onclick=\"location.href='../php/head_of_secretary_page.php'\" class=\"back-button\">←</button>";
    }
    ?>

    <button onclick="location.href='../php/logout.php'" class="logout-button">Log Out</button>

    <div class="container">
        <h1>Add New Course</h1>

        <form method="POST" action="../php/process_course_info.php">

        <label for="course_department">Department</label>

            <select id="course_department" name="course_department" required>
                
                <?php

                    if($_SESSION['emp_role'] == 'secretary') {
                        $sql_department = "SELECT * FROM departments INNER JOIN emp_department 
                                            ON emp_department.department_id = departments.department_id
                                            WHERE emp_id = " . $_SESSION['emp_id'];

                        $result_department = mysqli_query($conn, $sql_department) or die("1");

                        if (mysqli_num_rows($result_department) > 0){
                            echo "<option value=''>Select a department</option>";
                            while($row_department = mysqli_fetch_assoc($result_department)){
                                echo "<option value='" . $row_department['department_id'] . "'>" . $row_department['department_name'] . "</option>";
                            }
                        }
                    }

                    else if($_SESSION['emp_role'] == 'head_of_secretary') {

                        $sql_faculty = "SELECT * FROM departments INNER JOIN emp_faculty 
                                        ON emp_faculty.faculty_id = departments.faculty_id
                                        WHERE emp_id = " . $_SESSION['emp_id'];

                        $result_faculty = mysqli_query($conn, $sql_faculty) or die("2");

                        if(mysqli_num_rows($result_faculty) > 0){
                            echo "<option value=''>Select a department</option>";
                            while($row_faculty = mysqli_fetch_assoc($result_faculty)){
                                echo "<option value='" . $row_faculty['department_id'] . "'>" . $row_faculty['department_name'] . "</option>";
                            }
                        }
                    }
                ?>
            </select><br><br>

            <label for="course_term">Course Term</label>
            <select id="course_term" name="course_term" required>
                <option value="">Select a term</option>
                <option value="Spring">Spring</option>
                <option value="Fall">Fall</option>
            </select><br><br>

            <label for="course_code">Course Code</label>
            <input type="text" id="course_code" name="course_code" required><br><br>

            <label for="course_name">Course Name</label>
            <input type="text" id="course_name" name="course_name" required><br><br>

            <label for="course_credits">Course Credits</label>
            <input type="number" id="course_credits" name="course_credits" required><br><br>

            <label for="course_day_1">1. Course Day</label>
            <select id="course_day_1" name="course_day_1" required>
                <option value="">Select a day</option>
                <option value="1">Monday</option>
                <option value="2">Tuesday</option>
                <option value="3">Wednesday</option>
                <option value="4">Thursday</option>
                <option value="5">Friday</option>
                <option value="6">Saturday</option>
                <option value="7">Sunday</option>
            </select><br><br>

            <label for="course_time_1">1 .Course Time</label>
            <select id="course_time_1" name="course_time_1" required>
                <option value="">Select a time</option>
                <option value="09:00:00">09:00</option>
                <option value="10:00:00">10:00</option>
                <option value="11:00:00">11:00</option>
                <option value="12:00:00">12:00</option>
                <option value="13:00:00">13:00</option>
                <option value="14:00:00">14:00</option>
                <option value="15:00:00">15:00</option>
                <option value="16:00:00">16:00</option>
                <option value="17:00:00">17:00</option>
                <option value="18:00:00">18:00</option>
            </select><br><br>

            <label for="course_day_2">2. Course Day</label>
            <select id="course_day_2" name="course_day_2" required>
                <option value="">Select a day</option>
                <option value="1">Monday</option>
                <option value="2">Tuesday</option>
                <option value="3">Wednesday</option>
                <option value="4">Thursday</option>
                <option value="5">Friday</option>
                <option value="6">Saturday</option>
                <option value="7">Sunday</option>
            </select><br><br>

            <label for="course_time_2">2. Course Time</label>
            <select id="course_time_2" name="course_time_2" required>
                <option value="">Select a time</option>
                <option value="09:00:00">09:00</option>
                <option value="10:00:00">10:00</option>
                <option value="11:00:00">11:00</option>
                <option value="12:00:00">12:00</option>
                <option value="13:00:00">13:00</option>
                <option value="14:00:00">14:00</option>
                <option value="15:00:00">15:00</option>
                <option value="16:00:00">16:00</option>
                <option value="17:00:00">17:00</option>
                <option value="18:00:00">18:00</option>
            </select><br><br>

            <label for="course_day_3">3. Course Day</label>
            <select id="course_day_3" name="course_day_3" required>
                <option value="">Select a day</option>
                <option value="1">Monday</option>
                <option value="2">Tuesday</option>
                <option value="3">Wednesday</option>
                <option value="4">Thursday</option>
                <option value="5">Friday</option>
                <option value="6">Saturday</option>
                <option value="7">Sunday</option>
            </select><br><br>

            <label for="course_time_3">3. Course Time</label>
            <select id="course_time_3" name="course_time_3" required>
                <option value="">Select a time</option>
                <option value="09:00:00">09:00</option>
                <option value="10:00:00">10:00</option>
                <option value="11:00:00">11:00</option>
                <option value="12:00:00">12:00</option>
                <option value="13:00:00">13:00</option>
                <option value="14:00:00">14:00</option>
                <option value="15:00:00">15:00</option>
                <option value="16:00:00">16:00</option>
                <option value="17:00:00">17:00</option>
                <option value="18:00:00">18:00</option>
            </select><br><br>
            
            <input type="submit" value="Submit">
        </form>

        <?php

            if (isset($_GET['error'])) {
                if ($_GET['error'] == 101) {
                    echo "<p class='error'>Course code already exists.</p>";
                }
                else if ($_GET['error'] == 102) {
                    echo "<p class='error'>Course name already exists.</p>";
                }
                else if ($_GET['error'] == 103) {
                    echo "<p class='error'>An error occured.</p>";
                }
                else if ($_GET['error'] == 104) {
                    echo "<p class='error'>An error occured.</p>";
                }
            }
            else if (isset($_GET['success'])) {
                if ($_GET['success'] == "1" && isset($_GET['course_code'])) {
                    echo "<p class='success'>" . $_GET['course_code'] . " codded course added !</p>";

                }
            }

            mysqli_close($conn);
        ?>

    </div>
</body>

</html>
