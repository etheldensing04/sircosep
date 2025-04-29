<?php
require 'dbconnection.php';
session_start();
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in
if (!isset($_SESSION['assign_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit();
}

try {
    // Validate input data
    $assign_id = $_SESSION['assign_id'];
    $student_name = $_POST['student_name'] ?? '';
    $school = $_POST['school'] ?? '';
    $school_address = $_POST['school_address'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $coordinator = $_POST['coordinator'] ?? '';
    $organization = $_POST['organization'] ?? '';

    // Fetch current profile image
    $sql = "SELECT profile_image FROM students WHERE assign_id = :assign_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':assign_id', $assign_id);
    $stmt->execute();
    $current_image = $stmt->fetchColumn();

    // Handle profile image upload
    $profile_image = $current_image;
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        if ($current_image && $current_image != 'default-profile.jpg') {
            $old_image_path = './' . $current_image;
            if (file_exists($old_image_path)) {
                unlink($old_image_path); // Remove old image
            }
        }

        // Upload new image
        $profile_image = 'uploads/' . basename($_FILES['profile_image']['name']);
        if (!move_uploaded_file($_FILES['profile_image']['tmp_name'], $profile_image)) {
            echo json_encode(['error' => 'Failed to upload new profile image']);
            exit();
        }
    }

    // Update student profile
    $sql = "UPDATE students SET 
        student_name = :student_name, 
        school = :school, 
        school_address = :school_address, 
        contact = :contact, 
        coordinator = :coordinator, 
        organization = :organization, 
        profile_image = :profile_image 
        WHERE assign_id = :assign_id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':student_name', $student_name);
    $stmt->bindParam(':school', $school);
    $stmt->bindParam(':school_address', $school_address);
    $stmt->bindParam(':contact', $contact);
    $stmt->bindParam(':coordinator', $coordinator);
    $stmt->bindParam(':organization', $organization);
    $stmt->bindParam(':profile_image', $profile_image);
    $stmt->bindParam(':assign_id', $assign_id);
    $stmt->execute();

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
