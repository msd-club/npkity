<?php
ob_start(); // Start output buffering
?>

<!-- Page Heading -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class='bx bx-map'></i> Plots Management
    </h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPlotModal">
        <i class='bx bx-plus'></i> Add New Plot
    </button>
</div>

<!-- Search and Filter -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search plots by location or description...">
                    <button class="btn btn-outline-primary" type="button" id="searchButton">
                        <i class='bx bx-search'></i> Search
                    </button>
                </div>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-outline-secondary active" id="filterAll">
                        All Plots
                    </button>
                    <button type="button" class="btn btn-outline-secondary" id="filterActive">
                        Active Only
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Plots Table -->
<div class="card shadow">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class='bx bx-table'></i> Plots List
        </h6>
        <span class="badge bg-primary" id="totalPlots">Loading...</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="plotsTable" class="table table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Location</th>
                        <th>Description</th>
                        <th>Created Date</th>
                        <th>Last Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Plot Modal -->
<div class="modal fade" id="addPlotModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class='bx bx-plus'></i> Add New Plot
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addPlotForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="location" class="form-label">
                            <i class='bx bx-map-pin'></i> Location
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="location" name="location"
                            placeholder="Enter plot location (e.g., Field A - North Section)" required>
                        <div class="form-text">Enter a descriptive location for the plot</div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">
                            <i class='bx bx-text'></i> Description
                        </label>
                        <textarea class="form-control" id="description" name="description"
                            rows="3" placeholder="Enter plot description (optional)"></textarea>
                        <div class="form-text">Add any relevant details about this plot</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class='bx bx-x'></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class='bx bx-save'></i> Save Plot
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Plot Modal -->
<div class="modal fade" id="editPlotModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class='bx bx-edit'></i> Edit Plot
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editPlotForm">
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    <div class="mb-3">
                        <label for="edit_location" class="form-label">
                            <i class='bx bx-map-pin'></i> Location
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="edit_location" name="location" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">
                            <i class='bx bx-text'></i> Description
                        </label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class='bx bx-x'></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class='bx bx-save'></i> Update Plot
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deletePlotModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">
                    <i class='bx bx-trash'></i> Confirm Delete
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class='bx bx-error-circle bx-3x text-danger'></i>
                </div>
                <p class="text-center">Are you sure you want to delete this plot?</p>
                <p class="text-center text-muted" id="deletePlotInfo">Plot: <strong></strong></p>
                <p class="text-center text-danger small">
                    <i class='bx bx-info-circle'></i> This action cannot be undone.
                </p>
                <input type="hidden" id="delete_id" name="id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class='bx bx-x'></i> Cancel
                </button>
                <button type="button" class="btn btn-danger" id="confirmDelete">
                    <i class='bx bx-trash'></i> Delete Plot
                </button>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean(); // Get the buffered content
$page_title = "Plots Management";

// Include DataTables and plots.js
$extra_scripts = '
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<!-- Plots Management JS -->
<script src="assets/js/plots.js"></script>
';

// Include the base template
require_once 'layouts/base.php';
?>