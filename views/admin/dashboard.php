<?php
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: index.php?act=login');
    exit;
}

// Lấy dữ liệu thống kê từ controller
$total_products = $total_products ?? 0;
$total_categories = $total_categories ?? 0;
$total_users = $total_users ?? 0;

require_once 'layout/header_admin.php';
?>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                         <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tổng sản phẩm</div>
                           <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_products ?></div>
                    </div>
                       <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tổng danh mục</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_categories ?></div>
                        </div>
                     <div class="col-auto">
                            <i class="fas fa-folder fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tổng người dùng</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_users ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quản lý hệ thống</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                  <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="fas fa-box fa-3x mb-3 text-primary"></i>
                         <h5 class="card-title">Quản lý sản phẩm</h5>
                                    <p class="card-text">Thêm, sửa, xóa và quản lý các sản phẩm trong hệ thống</p>
                                    <a href="index.php?act=admin_products" class="btn btn-primary">Truy cập</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                    <div class="card">
                                <div class="card-body text-center">
                                    <i class="fas fa-folder fa-3x mb-3 text-success"></i>
                                    <h5 class="card-title">Quản lý danh mục</h5>
                                    <p class="card-text">Thêm, sửa, xóa và quản lý các danh mục sản phẩm</p>
                          <a href="index.php?act=admin_categories" class="btn btn-success">Truy cập</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <div class="card-body text-center">
                    <i class="fas fa-users fa-3x mb-3 text-info"></i>
                          <h5 class="card-title">Quản lý người dùng</h5>
                                    <p class="card-text">Quản lý thông tin và quyền hạn của người dùng</p>
                                    <a href="index.php?act=admin_users" class="btn btn-info">Truy cập</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
require_once 'layout/footer_admin.php';
?>