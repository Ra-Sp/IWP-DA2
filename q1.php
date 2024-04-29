<!DOCTYPE html>
<html>

<head>
    <title>Student Report</title>
    <style>
        form {
            margin: 0 auto;
            width: 300px;
        }

        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 60%;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .entry-separator {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h2>Student Information Form</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name"><br><br>
        <label for="age">Age:</label>
        <input type="number" id="age" name="age"><br><br>
        <label for="marks">Marks:</label>
        <input type="number" id="marks" name="marks"><br><br>

        <input type="submit" value="Submit">
    </form>

    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $file = fopen("report.txt", "a");
        $name = $_POST["name"];
        $age = $_POST["age"];
        $marks = $_POST["marks"];
        // Pre-written J component writeup, just appending it
        $jcomponent_writeup = "JComponent Writeup: This is a demonstration of writing data to a file using PHP and appending additional content.
";

        fwrite($file, "Name: $name\n");
        fwrite($file, "Age: $age\n");
        fwrite($file, "Marks: $marks\n");
        fwrite($file, $jcomponent_writeup);
    }

    $report = file_get_contents('report.txt');
    if (!empty($report)) {
        echo "<h2>Student Report</h2>";
        echo "<table>";
        echo "<tr><th>Field</th><th>Value</th></tr>";
        $entries = explode("\n\n", $report);
        foreach ($entries as $index => $entry) {
            $lines = explode("\n", $entry);
            foreach ($lines as $line) {
                $parts = explode(":", $line);
                if (count($parts) == 2) {
                    $field = trim($parts[0]);
                    $value = trim($parts[1]);
                    echo "<tr><td>$field</td><td>$value</td></tr>";
                }
            }
            if ($index < count($entries) - 1) {
                echo "<tr><td colspan='2'><hr></td></tr>";
            }
        }
        echo "</table>";
    }
    ?>
</body>

</html>