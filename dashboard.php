<?php
ob_start(); // Start output buffering
require_once 'api/connection.php';

// Get statistics
$conn = getConnection();

// Total plots
$plot_result = $conn->query("SELECT COUNT(*) as total FROM plots WHERE is_deleted = FALSE");
$total_plots = $plot_result->fetch_assoc()['total'];

// Total samples (we'll create this table later, for now mock data)
$total_samples = 45;

// Average nutrients (mock data for now)
$avg_nutrients = "N: 25ppm, P: 15ppm, K: 30ppm";

$conn->close();
?>

<!-- Page Heading -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class='bx bx-dashboard'></i> Dashboard
    </h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDataModal">
        <i class='bx bx-plus'></i> Add New Data
    </button>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-4 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Plots
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo $total_plots; ?>
                        </div>
                        <div class="mt-2">
                            <span class="text-success">
                                <i class='bx bx-up-arrow-alt'></i> Active monitoring
                            </span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class='bx bx-map-alt bx-2x text-primary'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Samples
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo $total_samples; ?>
                        </div>
                        <div class="mt-2">
                            <span class="text-info">
                                <i class='bx bx-test-tube'></i> Collected today: 3
                            </span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class='bx bx-data bx-2x text-success'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Average Nutrients
                        </div>
                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                            <?php echo htmlspecialchars($avg_nutrients); ?>
                        </div>
                        <div class="mt-2">
                            <span class="text-muted">
                                <i class='bx bx-trending-up'></i> Last 7 days average
                            </span>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class='bx bx-bar-chart-alt-2 bx-2x text-warning'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity & Quick Stats -->
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class='bx bx-history'></i> Recent Activity
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Plot</th>
                                <th>Action</th>
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Field A - North Section</td>
                                <td>New sensor reading</td>
                                <td>10 mins ago</td>
                                <td><span class="badge bg-success">Normal</span></td>
                            </tr>
                            <tr>
                                <td>Greenhouse 1</td>
                                <td>Nutrient level updated</td>
                                <td>1 hour ago</td>
                                <td><span class="badge bg-warning">Warning</span></td>
                            </tr>
                            <tr>
                                <td>Test Plot</td>
                                <td>Irrigation started</td>
                                <td>2 hours ago</td>
                                <td><span class="badge bg-info">Active</span></td>
                            </tr>
                            <tr>
                                <td>Orchard Section</td>
                                <td>Soil moisture low</td>
                                <td>3 hours ago</td>
                                <td><span class="badge bg-danger">Critical</span></td>
                            </tr>
                            <tr>
                                <td>Field B - South Section</td>
                                <td>Fertilizer applied</td>
                                <td>5 hours ago</td>
                                <td><span class="badge bg-success">Completed</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class='bx bx-stats'></i> Quick Stats
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-4">
                    <small class="text-muted">Active Sensors</small>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-success" style="width: 85%"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <small>17/20</small>
                        <small class="text-success">85%</small>
                    </div>
                </div>

                <div class="mb-4">
                    <small class="text-muted">Data Accuracy</small>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-info" style="width: 92%"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <small>92%</small>
                        <small class="text-info">Excellent</small>
                    </div>
                </div>

                <div class="mb-4">
                    <small class="text-muted">System Health</small>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-primary" style="width: 95%"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <small>95%</small>
                        <small class="text-primary">Optimal</small>
                    </div>
                </div>

                <div class="mb-4">
                    <small class="text-muted">Storage Usage</small>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-warning" style="width: 65%"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <small>3.2/5 GB</small>
                        <small class="text-warning">65%</small>
                    </div>
                </div>

                <hr>
                <div class="text-center">
                    <button class="btn btn-outline-primary btn-sm me-2">
                        <i class='bx bx-refresh'></i> Refresh Data
                    </button>
                    <button class="btn btn-outline-success btn-sm">
                        <i class='bx bx-download'></i> Export
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Top Performing Plots -->
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class='bx bx-star'></i> Top Performing Plots
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="card border-success">
                            <div class="card-body text-center">
                                <i class='bx bx-trophy bx-2x text-success mb-2'></i>
                                <h5>Field A</h5>
                                <p class="text-muted">N: 28ppm</p>
                                <div class="badge bg-success">Optimal</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card border-primary">
                            <div class="card-body text-center">
                                <i class='bx bx-medal bx-2x text-primary mb-2'></i>
                                <h5>Greenhouse 1</h5>
                                <p class="text-muted">P: 18ppm</p>
                                <div class="badge bg-primary">Good</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card border-warning">
                            <div class="card-body text-center">
                                <i class='bx bx-award bx-2x text-warning mb-2'></i>
                                <h5>Test Plot</h5>
                                <p class="text-muted">K: 35ppm</p>
                                <div class="badge bg-warning">Average</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card border-info">
                            <div class="card-body text-center">
                                <i class='bx bx-target-lock bx-2x text-info mb-2'></i>
                                <h5>Orchard</h5>
                                <p class="text-muted">pH: 6.5</p>
                                <div class="badge bg-info">Stable</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Data Modal -->
<div class="modal fade" id="addDataModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class='bx bx-plus'></i> Add New Data
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addDataForm">
                    <div class="mb-3">
                        <label for="dataPlot" class="form-label">Select Plot</label>
                        <select class="form-select" id="dataPlot" required>
                            <option value="">Choose a plot...</option>
                            <option value="1">Field A - North Section</option>
                            <option value="2">Field B - South Section</option>
                            <option value="3">Greenhouse 1</option>
                            <option value="4">Test Plot - Experimental</option>
                            <option value="5">Orchard Section</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="nitrogen" class="form-label">Nitrogen (N)</label>
                            <input type="number" class="form-control" id="nitrogen" placeholder="ppm" step="0.1">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="phosphorus" class="form-label">Phosphorus (P)</label>
                            <input type="number" class="form-control" id="phosphorus" placeholder="ppm" step="0.1">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="potassium" class="form-label">Potassium (K)</label>
                            <input type="number" class="form-control" id="potassium" placeholder="ppm" step="0.1">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" rows="2" placeholder="Additional observations..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class='bx bx-x'></i> Cancel
                </button>
                <button type="button" class="btn btn-primary">
                    <i class='bx bx-save'></i> Save Data
                </button>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean(); // Get the buffered content
$page_title = "Dashboard";

// Include the base template
require_once 'layouts/base.php';
?>