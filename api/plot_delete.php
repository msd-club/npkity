<?php
header('Content-Type: application/json');
require_once 'connection.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);

    if ($id <= 0) {
        $response['message'] = "Invalid plot ID!";
        echo json_encode($response);
        exit();
    }

    $conn = getConnection();

    // Soft delete (set is_deleted = TRUE and deleted_at = NOW())
    $stmt = $conn->prepare("UPDATE plot SET is_deleted = TRUE, deleted_at = NOW() WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Plot deleted successfully!";
    } else {
        $response['message'] = "Failed to delete plot. Please try again.";
    }

    $conn->close();
} else {
    $response['message'] = "Invalid request method!";
}

echo json_encode($response);
