<?php
header('Content-Type: application/json');
require_once 'connection.php';

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validation
    if (empty($email) || empty($username) || empty($password) || empty($confirm_password)) {
        $response['message'] = "All fields are required!";
        echo json_encode($response);
        exit();
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = "Please enter a valid email address!";
        echo json_encode($response);
        exit();
    }
    
    if ($password !== $confirm_password) {
        $response['message'] = "Passwords do not match!";
        echo json_encode($response);
        exit();
    }
    
    if (strlen($password) < 6) {
        $response['message'] = "Password must be at least 6 characters!";
        echo json_encode($response);
        exit();
    }
    
    $conn = getConnection();
    
    // Check if user exists
    $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
    $check_stmt->bind_param("ss", $email, $username);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows > 0) {
        $response['message'] = "Email or username already exists!";
        $conn->close();
        echo json_encode($response);
        exit();
    }
    
    // Create user
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (email, username, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $username, $hashed_password);
    
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = "Registration successful! You can now login.";
    } else {
        $response['message'] = "Registration failed. Please try again.";
    }
    
    $conn->close();
}

echo json_encode($response);
?>