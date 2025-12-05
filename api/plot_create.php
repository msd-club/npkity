<?php
header('Content-Type: application/json');
require_once 'connection.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $location = trim($_POST['location'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (empty($location)) {
        $response['message'] = "Location is required!";
        echo json_encode($response);
        exit();
    }

    $conn = getConnection();

    $stmt = $conn->prepare("INSERT INTO plot (location, description) VALUES (?, ?)");
    $stmt->bind_param("ss", $location, $description);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Plot created successfully!";
        $response['plot_id'] = $conn->insert_id;
    } else {
        $response['message'] = "Failed to create plot. Please try again.";
    }

    $conn->close();
} else {
    $response['message'] = "Invalid request method!";
}

echo json_encode($response);
