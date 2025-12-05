<?php
header('Content-Type: application/json');
require_once 'connection.php';

$response = ['success' => false, 'data' => null];

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    if ($id > 0) {
        $conn = getConnection();
        
        $stmt = $conn->prepare("SELECT * FROM plots WHERE id = ? AND is_deleted = FALSE");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($plot = $result->fetch_assoc()) {
            $response['success'] = true;
            $response['data'] = [
                'id' => $plot['id'],
                'location' => $plot['location'],
                'description' => $plot['description']
            ];
        } else {
            $response['message'] = "Plot not found!";
        }
        
        $conn->close();
    }
}

echo json_encode($response);
?>