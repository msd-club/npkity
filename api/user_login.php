<?php
header('Content-Type: application/json');
require_once 'connection.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $response['message'] = "Please enter username and password!";
        echo json_encode($response);
        exit();
    }
    
    $conn = getConnection();
    
    $stmt = $conn->prepare("SELECT id, username, email, password FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            
            $response['success'] = true;
            $response['message'] = "Login successful!";
            $response['redirect'] = "dashboard.php";
        } else {
            $response['message'] = "Invalid username or password!";
        }
    } else {
        $response['message'] = "Invalid username or password!";
    }
    
    $conn->close();
}

echo json_encode($response);
?>