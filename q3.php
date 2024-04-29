<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "covid_tracker";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to add record
function addRecord($vaccine_type, $name, $age, $conn)
{
    global $conn;
    $date_requested = date("Y-m-d");

    if ($vaccine_type == "covaxin") {
        $sql = "SELECT COUNT(*) AS count FROM covaxin WHERE date_requested >= CURDATE() - INTERVAL 7 DAY";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $count = $row["count"];

        if ($count >= 7) {
            $sql = "SELECT COUNT(*) AS count FROM covishield WHERE date_requested >= CURDATE() - INTERVAL 1 DAY";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $covishield_count = $row["count"];

            if ($covishield_count < 10) {
                $vaccine_type = "covishield";
                echo "<script>alert('Covaxin requests exceed limit. Covishield assigned.');</script>";
            } else {
                echo "<script>alert('Covaxin requests exceed limit and no vacancy for Covishield.');</script>";
                return;
            }
        }
    }

    if ($vaccine_type == "covishield") {
        $sql = "SELECT COUNT(*) AS count FROM covishield WHERE date_requested >= CURDATE() - INTERVAL 1 DAY";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $covishield_count = $row["count"];

        if ($covishield_count < 10) {
            $vaccine_type = "covishield";
        } else {
            echo "<script>alert('Covishield requests exceed limit.');</script>";
            return;
        }
    }

    // Insert record into respective table
    $sql = "INSERT INTO $vaccine_type (name, age, date_requested) VALUES ('$name', $age, '$date_requested')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record added successfully');</script>";
    } else {
        echo "<script>alert('Error: . $sql . <br> . $conn->error;');</script>";
    }
}

// Function to delete record based on patient ID
function deleteRecord($vaccine_type, $patient_id, $conn)
{
    global $conn;

    $sql = "SELECT * FROM $vaccine_type WHERE patient_id = $patient_id";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        echo "<script>alert('Patient with ID $patient_id does not exist.');</script>";
        return;
    }

    $sql = "DELETE FROM $vaccine_type WHERE patient_id = $patient_id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record deleted successfully');</script>";
    } else {
        echo "<script>alert('Error: . $sql . <br> . $conn->error;');</script>";
    }
}

// Function to display weekly counts
function displayWeeklyCounts($conn)
{
    global $conn;

    $sql = "SELECT DATE_FORMAT(date_requested, '%Y-%m-%d') AS date, 'Covaxin' AS vaccine_type, COUNT(*) AS count FROM covaxin WHERE date_requested >= CURDATE() - INTERVAL 7 DAY GROUP BY DATE(date_requested)
            UNION ALL
            SELECT DATE_FORMAT(date_requested, '%Y-%m-%d') AS date, 'Covishield' AS vaccine_type, COUNT(*) AS count FROM covishield WHERE date_requested >= CURDATE() - INTERVAL 7 DAY GROUP BY DATE(date_requested)
            ORDER BY date DESC, count DESC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Weekly Counts</h2>";
        echo "<table border='1'>
              <tr>
              <th>Date</th>
              <th>Vaccine Type</th>
              <th>Count</th>
              </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["date"] . "</td>";
            echo "<td>" . $row["vaccine_type"] . "</td>";
            echo "<td>" . $row["count"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "0 results";
    }
}

// Check if form is submitted for adding record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_add"])) {
    $vaccine_type = $_POST["vaccine_type"];
    $name = $_POST["name"];
    $age = $_POST["age"];
    addRecord($vaccine_type, $name, $age, $conn);
}

// Check if form is submitted for deleting record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_delete"])) {
    $vaccine_type = $_POST["vaccine_type"];
    $patient_id = $_POST["patient_id"];
    deleteRecord($vaccine_type, $patient_id, $conn);
}

// Display weekly counts
displayWeeklyCounts($conn);

$conn->close();
?>
<!DOCTYPE html>
<html>

<head>
    <title>COVID Tracker</title>
</head>

<body>
    <h2>Add Record</h2>
    <form method="post">
        <label for="vaccine_type">Vaccine Type:</label>
        <select id="vaccine_type" name="vaccine_type">
            <option value="covaxin">Covaxin</option>
            <option value="covishield">Covishield</option>
        </select><br><br>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name"><br><br>
        <label for="age">Age:</label>
        <input type="number" id="age" name="age"><br><br>
        <input type="submit" name="submit_add" value="Add Record">
    </form>

    <h2>Delete Record</h2>
    <form method="post">
        <label for="vaccine_type">Vaccine Type:</label>
        <select id="vaccine_type" name="vaccine_type">
            <option value="covaxin">Covaxin</option>
            <option value="covishield">Covishield</option>
        </select><br><br>
        <label for="patient_id">Patient ID:</label>
        <input type="number" id="patient_id" name="patient_id"><br><br>
        <input type="submit" name="submit_delete" value="Delete Record">
    </form>
</body>

</html>