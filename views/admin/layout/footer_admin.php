
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Shop Bán Hàng 2023</span>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>



    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
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


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    

    <?php if (isset($_GET['id']) && isset($_GET['act'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
          
            let editModal = null;
            
            <?php if ($_GET['act'] == 'admin_products'): ?>
            editModal = document.getElementById('editProductModal');
            <?php elseif ($_GET['act'] == 'admin_users'): ?>
            editModal = document.getElementById('editUserModal');
            <?php endif; ?>
            if (editModal) {
                const modal = new bootstrap.Modal(editModal);
                modal.show();
            }
        });
    </script>
    <?php endif; ?>
</body>
</html>