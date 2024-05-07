<!DOCTYPE html>
<html>

<head>
    <title>Secretary Page</title>
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
        
    </style>
</head>

<body>
    <button onclick="history.back()" class="back-button">←</button>
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

        <?php

            if (isset($_GET['error'])) {
                if ($_GET['error'] == "100") {
                    echo "<p class='error'>Course code does not exist!</p>";
                } else if ($_GET['error'] == "200") {
                    echo "<p class='error'>Course does not belong to your department!</p>";
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
        ?>

    </div>
</body>

</html>
