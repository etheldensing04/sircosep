<?php
require 'dbconnection.php';
session_start();
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['assign_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

$assign_id = $_SESSION['assign_id'];

// Fetch user profile details
$sql = "SELECT student_name, school, school_address, contact, coordinator, organization, profile_image FROM students WHERE assign_id = :assign_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(":assign_id", $assign_id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    echo json_encode([
        'student_name' => $result['student_name'],
        'school' => $result['school'],
        'school_address' => $result['school_address'],
        'contact' => $result['contact'],
        'coordinator' => $result['coordinator'],
        'organization' => $result['organization'],
        'profile_image' => $result['profile_image'] ?? 'default-profile.jpg'
    ]);
} else {
    echo json_encode(['error' => 'User not found']);
}
?>
