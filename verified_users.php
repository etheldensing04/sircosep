<?php
include('dbconnection.php'); // Ensure this file correctly initializes $pdo

header('Content-Type: application/json');

try {
    $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM students WHERE is_verified = 1");
    $stmt->execute();
    $result = $stmt->fetch();
    
    echo json_encode(["count" => $result['count']]);
} catch (PDOException $e) {
    echo json_encode(["error" => "Database query failed: " . $e->getMessage()]);
}
?>