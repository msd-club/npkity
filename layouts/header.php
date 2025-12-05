<?php
if (!isset($_SESSION)) {
	session_start();
}
if (!isset($_SESSION['user_id'])) {
	header("Location: ../index.php");
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo isset($page_title) ? $page_title . ' | ' : ''; ?>NPK Sensor Web UI</title>

	<!-- Bootstrap 5 CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

	<!-- DataTables CSS -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

	<!-- Custom CSS -->
	<link href="../assets/css/custom.css" rel="stylesheet">

	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-light">
	<div class="d-flex" id="wrapper">
		<!-- Sidebar -->
		<?php include 'sidebar.php'; ?>

		<!-- Page Content -->
		<div id="page-content-wrapper" class="w-100">
			<!-- Top Navbar -->
			<nav class="navbar navbar-expand-lg navbar-dark bg-primary border-bottom">
				<div class="container-fluid">
					<button class="btn btn-primary" id="sidebarToggle">
						<i class='bx bx-menu'></i>
					</button>

					<div class="navbar-brand d-none d-md-block">
						<!-- <i class='bx bx-leaf'></i> NPK Sensor Web UI -->
					</div>

					<div class="navbar-nav ms-auto">
						<div class="nav-item dropdown">
							<a class="nav-link dropdown-toggle text-white" href="#" role="button"
								data-bs-toggle="dropdown" aria-expanded="false">
								<i class='bx bx-user'></i> <?php echo htmlspecialchars($_SESSION['username']); ?>
							</a>
							<ul class="dropdown-menu dropdown-menu-end">
								<li><a class="dropdown-item" href="#">
										<i class='bx bx-cog'></i> Settings
									</a></li>
								<li>
									<hr class="dropdown-divider">
								</li>
								<li><a class="dropdown-item" href="../logout.php">
										<i class='bx bx-log-out'></i> Logout
									</a></li>
							</ul>
						</div>
					</div>
				</div>
			</nav>

			<!-- Main Content -->
			<div class="container-fluid px-4 pt-4">
			</div>
		</div>
	</div>
</body>