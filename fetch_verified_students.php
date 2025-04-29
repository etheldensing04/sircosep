<?php
// fetch_students.php
header('Content-Type: application/json');

// Database connection
$host = 'localhost';
$db = 'student_db';
$user = 'root';
$pass = '';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch verified students
$sql = "SELECT assign_id, student_name FROM students WHERE status = 'verified'";
$result = $conn->query($sql);

$students = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}

echo json_encode($students);
$conn->close();
?>