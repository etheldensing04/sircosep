<?php
session_start();
require 'dbconnection.php';

header("Content-Type: application/json"); 

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $response['success'] = false;
        $response['message'] = "Email and password are required.";
        echo json_encode($response);
        exit();
    }

    // Check if user exists
    $stmt = $pdo->prepare("SELECT assign_id, password, is_verified FROM students WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $response['success'] = false;
        $response['message'] = "User not found.";
    } elseif (!password_verify($password, $user['password'])) {
        $response['success'] = false;
        $response['message'] = "Invalid password.";
    } elseif ($user['is_verified'] == 0) {
        $response['success'] = false;
        $response['message'] = "Account not verified. Please check your email.";
    } else {
        // Login successful
        $_SESSION['assign_id'] = $user['assign_id']; // Corrected this line
        $response['success'] = true;
        $response['message'] = "Login successful!";
        $response['redirect'] = "dashboard.html"; // Redirect after login
    }
} else {
    $response['success'] = false;
    $response['message'] = "Invalid request method.";
}

echo json_encode($response);
exit();
?>
