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
    <title>Add Exam Page</title>
    <link rel="stylesheet" type="text/css" href="../styles/add_exam.css">
    <style>
        .error {
            text-align: center;
            color: red;
        }

        .success {
            text-align: center;
            color: green;
        }

        .back-button {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 10px 20px;
            float: left;
            background-color: #ccc;
            color: black;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .back-button:hover {
            color: white;
            background-color: black;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 5px;
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
        }

        .assigned-assistants {
            text-align: center;
        }

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        select option {
            background-color: #f0f0f0;
            padding: 5px;
            border-radius: 5px;
        }

        select option:hover {
            background-color: #ccc;
        }
        
    </style>
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
        <h1>Add New Exam</h1>

        <form method="POST" action="../php/process_exam_info.php">

            <label for="course_code">Course</label>
            <select id="course_code" name="course_code" required>
                <option value="">Select a course</option>
                <?php

                    if($_SESSION['emp_role'] == "secretary") {
                        $sql_department = "SELECT * FROM emp_department WHERE emp_id = " . $_SESSION['emp_id'];
                        $result_department = mysqli_query($conn, $sql_department) or die("10");
                        $row_department = mysqli_fetch_assoc($result_department);
    
                        $sql_courses = "SELECT * FROM courses WHERE department_id = " . $row_department['department_id'];
                        $result_courses = mysqli_query($conn, $sql_courses) or die("11");

                        if (mysqli_num_rows($result_courses) > 0){
                            while($row_courses = mysqli_fetch_assoc($result_courses)){
                                echo "<option value='" . $row_courses['course_code'] . "'>" . $row_courses['course_code'] . " - " . $row_courses['course_name']  . "</option>";
                            }
                        }
                    }
                    else if($_SESSION['emp_role'] == "head_of_secretary") {
                        $sql_faculty = "SELECT * FROM emp_faculty WHERE emp_id = " . $_SESSION['emp_id'];
                        $result_faculty = mysqli_query($conn, $sql_faculty) or die("12");
                        $row_faculty = mysqli_fetch_assoc($result_faculty);

                        $sql_department = "SELECT * FROM departments WHERE faculty_id = " . $row_faculty['faculty_id'];
                        $result_department = mysqli_query($conn, $sql_department) or die("13");

                        if(mysqli_num_rows($result_department) > 0){
                            while($row_department = mysqli_fetch_assoc($result_department)){

                                $sql_courses = "SELECT * FROM courses WHERE department_id = " . $row_department['department_id'];
                                $result_courses = mysqli_query($conn, $sql_courses) or die("14");

                                if (mysqli_num_rows($result_courses) > 0){
                                    while($row_courses = mysqli_fetch_assoc($result_courses)){
                                        echo "<option value='" . $row_courses['course_code'] . "'>" . $row_courses['course_code'] . " - " . $row_courses['course_name']  . "</option>";
                                    }
                                }
                            }
                        }
                    }
                ?>
            </select><br><br>

            <label for="num_class">Number of Classes</label>
            <input type="number" id="num_class" name="num_class" required>

            <label for="num_assistants">Number of Assistants</label>
            <input type="number" id="num_assistants" name="num_assistants" required>

            <label for="date">Date</label>
            <input type="date" id="date" name="date" required>

            <label for="time">Time</label>
            <input type="time" id="time" name="time" required>

            <input type="submit" value="Submit">
        </form>

        <?php

            if (isset($_GET['error'])) {
                if ($_GET['error'] == "100") {
                    echo "<p class='error'>Not enough assistants found.</p>";
                }
            }
            else if (isset($_GET['success'])) {
                if ($_GET['success'] == "1") {
                    echo "<p class='success'>Exam added successfully!</p>";

                    if (isset($_GET['assigned_assistants'])) {
                        echo "<h2 class='assigned-assistants'>Assigned Assistants</h2>";
                        echo "<ul class='assigned-assistants'>";
                        $assigned_assistants = explode(",", $_GET['assigned_assistants']);
                        foreach ($assigned_assistants as $assistant) {
                            echo "<li class='assigned-assistants'>" . $assistant . "</li>";
                        }
                        echo "</ul>";
                    }
                }
            }

            mysqli_close($conn);
        ?>

    </div>
</body>

</html>
