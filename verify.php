<?php
require 'dbconnection.php';

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Update verification status in the database
    $stmt = $pdo->prepare("UPDATE students SET is_verified = 1, verification_code = NULL WHERE verification_code = :code");
    $stmt->bindParam(':code', $code);

    if ($stmt->execute() && $stmt->rowCount() > 0) {
        // Redirect to login page with success message
        header("Location: login.html?message=verified");
        exit();
    } else {
        echo "Invalid or expired verification code.";
    }
} else {
    echo "No verification code provided.";
}
?>
