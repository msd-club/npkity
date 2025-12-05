            </div> <!-- End of container-fluid -->
        </div> <!-- End of page-content-wrapper -->
    </div> <!-- End of wrapper -->

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script>
    // Toggle sidebar
    $("#sidebarToggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
        const icon = $(this).find('i');
        if ($("#wrapper").hasClass("toggled")) {
            icon.removeClass('bx-menu').addClass('bx-menu-alt-right');
        } else {
            icon.removeClass('bx-menu-alt-right').addClass('bx-menu');
        }
    });

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    </script>

</body>
</html>