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
    <title>Assitants' Scores</title>
    <link rel="stylesheet" type="text/css" href="../styles/course_info.css">
    <style>
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
    </style>
</head>

<body>
    <button onclick="location.href='../php/head_of_department_page.php'" class="back-button">←</button>
    <button onclick="location.href='../php/logout.php'" class="logout-button">Log Out</button>
    <h2>Asistants Scores</h2>
    <table>
        <thead>
            <tr>
                <th>Assistant Name</th>
                <th>Assistant Surname</th>
                <th>Assistant Score</th>
                <th>Assistant Score (Percentage)</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $sql_assistants = "SELECT * FROM employees WHERE emp_role = 'assistant'";
            $result_assistants = mysqli_query($conn, $sql_assistants) or die("16");

            $sql_scores = "SELECT SUM(emp_score) as score_sum FROM employees WHERE emp_role = 'assistant'";
            $result_scores = mysqli_query($conn, $sql_scores) or die("17");
            $row_scores = mysqli_fetch_assoc($result_scores);

            if (mysqli_num_rows($result_assistants) > 0) {
                while ($row_assistants = mysqli_fetch_assoc($result_assistants)) {
                    echo "<tr>";
                    echo "<td>" . $row_assistants['emp_name'] . "</td>";
                    echo "<td>" . $row_assistants['emp_surname'] . "</td>";
                    echo "<td>" . $row_assistants['emp_score'] . "</td>";
                    echo "<td>" . round(($row_assistants['emp_score'] / $row_scores['score_sum']) * 100, 2) . "%</td>";
                    echo "</tr>";
                }
            }
            else {
                mysqli_close($conn);
                header("Location: ../php/secretary_page.php?error=101");
                exit();
            }

            mysqli_close($conn);
            ?>
        </tbody>
    </table>
</body>

</html>
