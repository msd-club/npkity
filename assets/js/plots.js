$(document).ready(function() {
    // Initialize DataTable
    let plotsTable = $('#plotsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: 'api/plot_list.php',
            type: 'GET',
            data: function(d) {
                // Add custom filters if needed
                const activeFilter = $('#filterActive').hasClass('active');
                if (activeFilter) {
                    d.active_only = 1;
                }
            }
        },
        columns: [
            { 
                data: 'id',
                className: 'text-center'
            },
            { 
                data: 'location',
                render: function(data, type, row) {
                    return `<strong>${data}</strong>`;
                }
            },
            { 
                data: 'description',
                render: function(data, type, row) {
                    return data || '<span class="text-muted">No description</span>';
                }
            },
            { 
                data: 'create_date',
                className: 'text-center',
                render: function(data) {
                    return `<span class="badge bg-secondary">${data}</span>`;
                }
            },
            { 
                data: 'update_date',
                className: 'text-center',
                render: function(data) {
                    return `<span class="badge bg-info">${data}</span>`;
                }
            },
            { 
                data: 'actions',
                render: function(data, type, row) {
                    return `
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-info view-plot" data-id="${row.id}" 
                                    data-bs-toggle="tooltip" title="View Details">
                                <i class='bx bx-show'></i>
                            </button>
                            <button class="btn btn-sm btn-warning edit-plot" data-id="${row.id}" 
                                    data-bs-toggle="tooltip" title="Edit Plot">
                                <i class='bx bx-edit'></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-plot" data-id="${row.id}" 
                                    data-bs-toggle="tooltip" title="Delete Plot">
                                <i class='bx bx-trash'></i>
                            </button>
                        </div>
                    `;
                },
                orderable: false,
                searchable: false,
                className: 'text-center'
            }
        ],
        pageLength: 10,
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
        responsive: true,
        language: {
            search: "Search plots:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ plots",
            infoEmpty: "No plots found",
            infoFiltered: "(filtered from _MAX_ total plots)",
            zeroRecords: "No matching plots found"
        },
        initComplete: function() {
            // Update total plots count
            const info = this.api().page.info();
            $('#totalPlots').text(`${info.recordsTotal} plots`);
        }
    });

    // Search functionality
    $('#searchButton').click(function() {
        plotsTable.search($('#searchInput').val()).draw();
    });

    $('#searchInput').on('keyup', function(e) {
        if (e.key === 'Enter') {
            plotsTable.search(this.value).draw();
        }
    });

    // Filter buttons
    $('#filterAll, #filterActive').click(function() {
        const filterType = $(this).attr('id');
        $('[id^="filter"]').removeClass('active');
        $(this).addClass('active');
        
        // Redraw table with filter
        plotsTable.ajax.reload();
    });

    // View Plot Details
    $(document).on('click', '.view-plot', function() {
        const plotId = $(this).data('id');
        showAlert('View feature coming soon! Plot ID: ' + plotId, 'info');
    });

    // Edit Plot - Open Modal (using AJAX)
    $(document).on('click', '.edit-plot', function() {
        const plotId = $(this).data('id');
        const row = $(this).closest('tr');
        const location = row.find('td:eq(1)').text();
        const description = row.find('td:eq(2)').text();
        
        // Fill modal with data
        $('#edit_id').val(plotId);
        $('#edit_location').val(location);
        $('#edit_description').val(description === 'No description' ? '' : description);
        $('#editPlotModal').modal('show');
    });

    // Add Plot Form Submission
    $('#addPlotForm').submit(function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        submitBtn.html('<span class="spinner-border spinner-border-sm"></span> Saving...').prop('disabled', true);
        
        $.ajax({
            url: 'api/plot_create.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Close modal and reset form
                    $('#addPlotModal').modal('hide');
                    $('#addPlotForm')[0].reset();
                    
                    // Show success message
                    showAlert('Plot added successfully!', 'success');
                    
                    // Reload table
                    plotsTable.ajax.reload(null, false); // false to keep current page
                } else {
                    showAlert(response.message, 'danger');
                }
                submitBtn.html(originalText).prop('disabled', false);
            },
            error: function() {
                showAlert('An error occurred. Please try again.', 'danger');
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // Edit Plot Form Submission
    $('#editPlotForm').submit(function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        const submitBtn = $(this).find('button[type="submit"]');
        const originalText = submitBtn.html();
        
        submitBtn.html('<span class="spinner-border spinner-border-sm"></span> Updating...').prop('disabled', true);
        
        $.ajax({
            url: 'api/plot_update.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#editPlotModal').modal('hide');
                    showAlert('Plot updated successfully!', 'success');
                    plotsTable.ajax.reload(null, false);
                } else {
                    showAlert(response.message, 'danger');
                }
                submitBtn.html(originalText).prop('disabled', false);
            },
            error: function() {
                showAlert('An error occurred. Please try again.', 'danger');
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // Delete Plot - Open Confirmation
    $(document).on('click', '.delete-plot', function() {
        const plotId = $(this).data('id');
        const location = $(this).closest('tr').find('td:eq(1)').text();
        
        $('#delete_id').val(plotId);
        $('#deletePlotInfo strong').text(location);
        $('#deletePlotModal').modal('show');
    });

    // Delete Plot - Confirm
    $('#confirmDelete').click(function() {
        const plotId = $('#delete_id').val();
        const deleteBtn = $(this);
        const originalText = deleteBtn.html();
        
        deleteBtn.html('<span class="spinner-border spinner-border-sm"></span> Deleting...').prop('disabled', true);
        
        $.ajax({
            url: 'api/plot_delete.php',
            type: 'POST',
            data: { id: plotId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#deletePlotModal').modal('hide');
                    showAlert('Plot deleted successfully!', 'success');
                    plotsTable.ajax.reload(null, false);
                } else {
                    showAlert(response.message, 'danger');
                }
                deleteBtn.html(originalText).prop('disabled', false);
            },
            error: function() {
                showAlert('An error occurred. Please try again.', 'danger');
                deleteBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // Modal reset handlers
    $('#addPlotModal').on('hidden.bs.modal', function() {
        $('#addPlotForm')[0].reset();
    });

    $('#editPlotModal').on('hidden.bs.modal', function() {
        $('#editPlotForm')[0].reset();
    });

    // Helper function to show alerts
    function showAlert(message, type) {
        // Remove existing alerts
        $('.alert-dismissible').remove();
        
        const alert = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert" style="position: fixed; top: 80px; right: 20px; z-index: 9999; min-width: 300px;">
                <div class="d-flex align-items-center">
                    <i class='bx ${type === 'success' ? 'bx-check-circle' : type === 'danger' ? 'bx-error-circle' : 'bx-info-circle'} me-2'></i>
                    <div>${message}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        $('body').append(alert);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            $('.alert-dismissible').alert('close');
        }, 5000);
    }

    // Initialize tooltips
    $(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
});