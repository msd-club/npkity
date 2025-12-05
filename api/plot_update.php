<?php
header('Content-Type: application/json');
require_once 'connection.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $location = trim($_POST['location'] ?? '');
    $description = trim($_POST['description'] ?? '');
    
    if ($id <= 0) {
        $response['message'] = "Invalid plot ID!";
        echo json_encode($response);
        exit();
    }
    
    if (empty($location)) {
        $response['message'] = "Location is required!";
        echo json_encode($response);
        exit();
    }
    
    $conn = getConnection();
    
    $stmt = $conn->prepare("UPDATE plots SET location = ?, description = ? WHERE id = ? AND is_deleted = FALSE");
    $stmt->bind_param("ssi", $location, $description, $id);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $response['success'] = true;
            $response['message'] = "Plot updated successfully!";
        } else {
            $response['message'] = "Plot not found or no changes made.";
        }
    } else {
        $response['message'] = "Failed to update plot. Please try again.";
    }
    
    $conn->close();
} else {
    $response['message'] = "Invalid request method!";
}

echo json_encode($response);
?>