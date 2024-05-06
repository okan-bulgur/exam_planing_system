<!DOCTYPE html>
<html>

<head>
    <title>Secretary Page</title>
    <link rel="stylesheet" type="text/css" href="../styles/add_exam.css">
</head>

<body>
    <button onclick="location.href='../php/logout.php'" class="logout-button">Log Out</button>
    <div class="container">
        <h1>Add New Exam</h1>

        <form method="POST" action="../php/process_exam_info.php">

            <label for="course_code">Course Code</label>
            <input type="text" id="course_code" name="course_code" required>

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

    </div>
</body>

</html>
