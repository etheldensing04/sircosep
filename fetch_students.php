<?php
include('dbconnection.php');

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0); 

try {
    $stmt = $pdo->query("SELECT assign_id, student_name, school, school_address, contact, is_verified FROM students");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$students) {
        ob_clean(); // Clear any previous output
        echo json_encode(['error' => 'No students found']);
        exit;
    }

    error_log(print_r($students, TRUE)); // Log data for debugging

    ob_clean(); // Ensure only JSON is output
    echo json_encode($students);
    exit;
} catch (PDOException $e) {
    ob_clean();
    echo json_encode(['error' => "Database error: " . $e->getMessage()]);
    error_log("Database error: " . $e->getMessage());
    exit;
}

$pdo = null;
?>
