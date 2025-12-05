<?php
require_once 'api/connection.php';

if (!isLoggedIn()) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | NPK Sensor Web UI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class='bx bx-leaf'></i> NPK Sensor Dashboard
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>
                </span>
                <a href="logout.php" class="btn btn-outline-light">
                    <i class='bx bx-log-out'></i> Logout
                </a>
            </div>
        </div>
    </nav>
    
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>NPK Sensor Monitoring</h4>
                    </div>
                    <div class="card-body">
                        <p>Your dashboard is ready for NPK sensor data visualization.</p>
                        <p>User Email: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>