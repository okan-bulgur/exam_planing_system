<?php
    session_start();

    if (!isset($_SESSION['emp_username'])) {
        header("Location: ../html/login.html"); // Replace with the login page URL
        exit();
    }

?>

<!DOCTYPE html>
<html>

<head>
    <title>Assistant Page</title>
    <link rel="stylesheet" type="text/css" href="../styles/course_info.css">
</head>

<body>
    <h2>Course Information</h2>
    <table>
        <thead>
            <tr>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Course Credits</th>
                <th>Course Term</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($_SESSION['course_list'] as $course) {
                if ($course['course_id'] == $_POST['selected_course']) {
                    echo "<tr>";
                    echo "<td>" . $course['course_code'] . "</td>";
                    echo "<td>" . $course['course_name'] . "</td>";
                    echo "<td>" . $course['course_credits'] . "</td>";
                    echo "<td>" . $course['course_term'] . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>

    <button onclick="location.href='../php/logout.php'" class="logout-button">Log Out</button>
</body>

</html>
