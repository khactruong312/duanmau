<!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Shop Bán Hàng 2023</span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->
            </div>
            <!-- End of Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bạn muốn đăng xuất?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Chọn "Đăng xuất" bên dưới nếu bạn đã sẵn sàng kết thúc phiên làm việc hiện tại.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Hủy</button>
                    <a class="btn btn-primary" href="index.php?act=logout">Đăng xuất</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script>
        // Toggle the side navigation
        document.getElementById('sidebarToggle').addEventListener('click', function(e) {
            document.getElementById('sidebar').classList.toggle('toggled');
            document.getElementById('content-wrapper').classList.toggle('toggled');
        });

        document.getElementById('sidebarToggleTop').addEventListener('click', function(e) {
            document.getElementById('sidebar').classList.toggle('toggled');
            document.getElementById('content-wrapper').classList.toggle('toggled');
        });

        // Close any open menu accordions when window is resized below 768px
        window.addEventListener('resize', function() {
            if (window.innerWidth < 768) {
                document.getElementById('sidebar').classList.add('toggled');
                document.getElementById('content-wrapper').classList.remove('toggled');
            } else {
                document.getElementById('sidebar').classList.remove('toggled');
                document.getElementById('content-wrapper').classList.remove('toggled');
            }
        });

        // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
        document.querySelector('body.fixed-nav #sidebar').addEventListener('mousewheel', function(e) {
            if (window.innerWidth > 768) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>