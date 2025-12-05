<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!-- Sidebar -->
<div class="bg-dark border-right" id="sidebar-wrapper" style="width: 250px;">
	<div class="sidebar-heading text-center py-4 bg-dark text-white">
		<h5 class="mb-0">
			<i class='bx bx-leaf text-success'></i> NPK Monitor
		</h5>
		<small class="text-muted">Sensor Management System</small>
	</div>

	<div class="list-group list-group-flush">
		<a href="dashboard.php"
			class="list-group-item list-group-item-action bg-dark text-white <?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
			<i class='bx bx-dashboard me-2'></i> Dashboard
		</a>

		<a href="plots.php"
			class="list-group-item list-group-item-action bg-dark text-white <?php echo ($current_page == 'plots.php') ? 'active' : ''; ?>">
			<i class='bx bx-map me-2'></i> Plots
		</a>
	</div>

	<div class="sidebar-footer mt-auto p-3 bg-dark text-center border-top">
		<small class="text-muted">NPK Sensor v1.0</small>
	</div>
</div>