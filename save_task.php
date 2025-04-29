<?php
header("Content-Type: application/json");
require_once "dbconnection.php";

$data = json_decode(file_get_contents("php://input"), true);

$title = $data['title'];
$description = $data['description'];
$assigned_to = $data['assigned_to'];
$deadline = $data['deadline'];

try {
    $stmt = $conn->prepare("INSERT INTO tasks (title, description, assigned_to, deadline, status) 
                           VALUES (?, ?, ?, ?, 'Pending')");
    $stmt->execute([$title, $description, $assigned_to, $deadline]);
    
    echo json_encode(["success" => true]);
} catch(PDOException $e) {
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
?>