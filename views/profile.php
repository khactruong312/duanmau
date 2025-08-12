<?php
// Lấy dữ liệu từ controller
$user = $user ?? [];
$error = $error ?? '';
$success = $success ?? '';
$categories = $categories ?? [];

// Include header
require_once 'layout/header.php';
?>

<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <img src="https://via.placeholder.com/150" class="rounded-circle mb-3" alt="Avatar">
                    <h5 class="mb-1"><?= $user['fullname'] ?></h5>
                    <p class="text-muted"><?= $user['email'] ?></p>
                </div>
            </div>
            <div class="list-group mb-4">
                <a href="index.php?act=profile" class="list-group-item list-group-item-action active">
                    <i class="fas fa-user me-2"></i> Thông tin cá nhân
                </a>
                <a href="index.php?act=my_orders" class="list-group-item list-group-item-action">
                    <i class="fas fa-shopping-bag me-2"></i> Đơn hàng của tôi
                </a>
                <a href="index.php?act=change_password" class="list-group-item list-group-item-action">
                    <i class="fas fa-key me-2"></i> Đổi mật khẩu
                </a>
                <a href="index.php?act=logout" class="list-group-item list-group-item-action text-danger">
                    <i class="fas fa-sign-out-alt me-2"></i> Đăng xuất
                </a>
            </div>
        </div>
        
        <!-- Main content -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Thông tin cá nhân</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success"><?= $success ?></div>
                    <?php endif; ?>
                    
                    <form action="index.php?act=profile" method="post">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="username" class="form-label">Tên đăng nhập</label>
                                <input type="text" class="form-control" id="username" value="<?= $user['username'] ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="fullname" class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" value="<?= $user['fullname'] ?>" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="<?= $user['phone'] ?>">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <textarea class="form-control" id="address" name="address" rows="3"><?= $user['address'] ?></textarea>
                        </div>
                        
                        <hr class="my-4">
                        
                        <h5 class="mb-3">Đổi mật khẩu</h5>
                        <p class="text-muted mb-3">Để trống nếu bạn không muốn thay đổi mật khẩu</p>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
                                <input type="password" class="form-control" id="current_password" name="current_password">
                            </div>
                            <div class="col-md-4">
                                <label for="new_password" class="form-label">Mật khẩu mới</label>
                                <input type="password" class="form-control" id="new_password" name="new_password">
                            </div>
                            <div class="col-md-4">
                                <label for="confirm_password" class="form-label">Xác nhận mật khẩu</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">Cập nhật thông tin</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Include footer
require_once 'layout/footer.php';
?>