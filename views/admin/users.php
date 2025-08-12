<?php
// Kiểm tra quyền truy cập
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: index.php?act=login');
    exit;
}

// Lấy thông báo lỗi nếu có
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);

// Lấy thông báo thành công nếu có
$success = isset($_SESSION['success']) ? $_SESSION['success'] : '';
unset($_SESSION['success']);

// Lấy thông tin người dùng cần sửa (nếu có)
$user_edit = $user_edit ?? null;

// Lấy danh sách người dùng
$users = $users ?? [];
?>

<?php include_once 'layout/header_admin.php'; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý người dùng</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fas fa-plus fa-sm text-white-50"></i> Thêm người dùng mới
        </button>
    </div>

    <?php if (!empty($success)): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $success ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>
    
    <?php if (!empty($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $error ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách người dùng</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên đăng nhập</th>
                            <th>Họ và tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Vai trò</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= $user['username'] ?></td>
                            <td><?= $user['fullname'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['phone'] ?></td>
                            <td>
                                <?php if ($user['role'] == 'admin'): ?>
                                    <span class="badge bg-primary">Admin</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Khách hàng</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $user['created_at'] ?></td>
                            <td>
                                <a href="index.php?act=admin_users&id=<?= $user['id'] ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if ($user['id'] != $_SESSION['user']['id']): ?>
                                <a href="index.php?act=admin_users_delete&id=<?= $user['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Thêm người dùng mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php?act=admin_users_add" method="post">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="username" class="form-label">Tên đăng nhập</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fullname" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="col-md-6">
                            <label for="role" class="form-label">Vai trò</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="customer">Khách hàng</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu người dùng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<?php if ($user_edit): ?>
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Sửa thông tin người dùng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php?act=admin_users_update" method="post">
                    <input type="hidden" name="id" value="<?= $user_edit['id'] ?>">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_username" class="form-label">Tên đăng nhập</label>
                            <input type="text" class="form-control" id="edit_username" name="username" value="<?= $user_edit['username'] ?>" required <?= ($user_edit['id'] == $_SESSION['user']['id']) ? 'readonly' : '' ?>>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_fullname" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" id="edit_fullname" name="fullname" value="<?= $user_edit['fullname'] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" value="<?= $user_edit['email'] ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_phone" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="edit_phone" name="phone" value="<?= $user_edit['phone'] ?>" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="edit_password" name="password" placeholder="Để trống nếu không thay đổi">
                            <small class="text-muted">Để trống nếu không muốn thay đổi mật khẩu</small>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_role" class="form-label">Vai trò</label>
                            <select class="form-select" id="edit_role" name="role" required <?= ($user_edit['id'] == $_SESSION['user']['id']) ? 'disabled' : '' ?>>
                                <option value="customer" <?= ($user_edit['role'] == 'customer') ? 'selected' : '' ?>>Khách hàng</option>
                                <option value="admin" <?= ($user_edit['role'] == 'admin') ? 'selected' : '' ?>>Admin</option>
                            </select>
                            <?php if ($user_edit['id'] == $_SESSION['user']['id']): ?>
                            <input type="hidden" name="role" value="<?= $user_edit['role'] ?>">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_address" class="form-label">Địa chỉ</label>
                        <textarea class="form-control" id="edit_address" name="address" rows="3"><?= $user_edit['address'] ?></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Cập nhật người dùng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Hiển thị modal chỉnh sửa khi trang được tải
    document.addEventListener('DOMContentLoaded', function() {
        var editUserModal = new bootstrap.Modal(document.getElementById('editUserModal'));
        editUserModal.show();
    });
</script>
<?php endif; ?>

<?php include_once 'layout/footer_admin.php'; ?>

<!-- Page level plugins -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

<!-- Page level custom scripts -->
<script>
    // Call the dataTables jQuery plugin
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>