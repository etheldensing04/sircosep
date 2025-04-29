<?php
include 'dbconnection.php';

header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0); 

try {
    $stmt = $pdo->prepare("
        SELECT t.*, u.name as assigned_name 
        FROM tasks t 
        JOIN users u ON t.assigned_to = u.id
        ORDER BY t.deadline ASC
    ");
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$tasks) {
        ob_clean(); 
        echo json_encode(['error' => 'No tasks found']);
        exit;
    }

    error_log(print_r($tasks, TRUE)); 

    ob_clean(); 
    echo json_encode($tasks);
    exit;
} catch (PDOException $e) {
    ob_clean();
    echo json_encode(['error' => "Database error: " . $e->getMessage()]);
    error_log("Database error: " . $e->getMessage());
    exit;
}