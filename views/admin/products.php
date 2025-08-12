<?php
// Kiểm tra quyền truy cập
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: index.php?act=login');
    exit;
}

// Lấy thông báo nếu có
$success = isset($_SESSION['success']) ? $_SESSION['success'] : '';
$error = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['success']);
unset($_SESSION['error']);

// Lấy danh sách danh mục để hiển thị trong form thêm/sửa sản phẩm
$categories = $categories ?? [];

// Lấy thông tin sản phẩm cần sửa (nếu có)
$product_edit = $product_edit ?? null;

// Lấy danh sách sản phẩm
$products = $products ?? [];
?>

<?php include_once 'layout/header_admin.php'; ?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý sản phẩm</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="fas fa-plus fa-sm text-white-50"></i> Thêm sản phẩm mới
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
            <h6 class="m-0 font-weight-bold text-primary">Danh sách sản phẩm</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Giảm giá</th>
                            <th>Danh mục</th>
                            <th>Lượt xem</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= $product['id'] ?></td>
                            <td>
                                <?php if (!empty($product['image'])): ?>
                                    <img src="uploads/imgproduct/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" width="50" class="img-thumbnail">
                                <?php else: ?>
                                    <span class="text-muted">Không có ảnh</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $product['name'] ?></td>
                            <td><?= number_format($product['price'], 0, ',', '.') ?> đ</td>
                            <td><?= number_format($product['discount'], 0, ',', '.') ?> đ</td>
                            <td><?= $product['category_name'] ?></td>
                            <td><?= $product['view'] ?></td>
                            <td>
                                <a href="index.php?act=admin_products&id=<?= $product['id'] ?>" class="btn btn-info btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="index.php?act=admin_products_delete&id=<?= $product['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                    <i class="fas fa-trash"></i>
                                </a>
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

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Thêm sản phẩm mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php?act=admin_products_add" method="post" enctype="multipart/form-data">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="category_id" class="form-label">Danh mục</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">Chọn danh mục</option>
                                <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="price" class="form-label">Giá</label>
                            <input type="number" class="form-control" id="price" name="price" min="0" required>
                        </div>
                        <div class="col-md-6">
                            <label for="discount" class="form-label">Giảm giá</label>
                            <input type="number" class="form-control" id="discount" name="discount" min="0" value="0">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Số lượng</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="0" value="0" required>
                        </div>
                        <div class="col-md-6">
                            <label for="image" class="form-label">Hình ảnh</label>
                            <input type="file" class="form-control" id="image" name="image" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="detail" class="form-label">Chi tiết sản phẩm</label>
                        <textarea class="form-control" id="detail" name="detail" rows="5"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Lưu sản phẩm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<?php if ($product_edit): ?>
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Sửa sản phẩm</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="index.php?act=admin_products_update" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $product_edit['id'] ?>">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_name" class="form-label">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="edit_name" name="name" value="<?= $product_edit['name'] ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_category_id" class="form-label">Danh mục</label>
                            <select class="form-select" id="edit_category_id" name="category_id" required>
                                <option value="">Chọn danh mục</option>
                                <?php foreach ($categories as $category): ?>
                                <option value="<?= $category['id'] ?>" <?= ($category['id'] == $product_edit['category_id']) ? 'selected' : '' ?>>
                                    <?= $category['name'] ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_price" class="form-label">Giá</label>
                            <input type="number" class="form-control" id="edit_price" name="price" min="0" value="<?= $product_edit['price'] ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_discount" class="form-label">Giảm giá</label>
                            <input type="number" class="form-control" id="edit_discount" name="discount" min="0" value="<?= $product_edit['discount'] ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_quantity" class="form-label">Số lượng</label>
                            <input type="number" class="form-control" id="edit_quantity" name="quantity" min="0" value="<?= $product_edit['quantity'] ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_image" class="form-label">Hình ảnh hiện tại</label>
                            <div>
                                <?php if (!empty($product_edit['image'])): ?>
                                    <img src="uploads/imgproduct/<?= $product_edit['image'] ?>" alt="<?= $product_edit['name'] ?>" width="100" class="mb-2 img-thumbnail">
                                <?php else: ?>
                                    <p class="text-muted">Không có ảnh</p>
                                <?php endif; ?>
                            </div>
                            <input type="file" class="form-control" id="edit_image" name="image">
                            <small class="text-muted">Chỉ chọn ảnh nếu muốn thay đổi</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"><?= $product_edit['description'] ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_detail" class="form-label">Chi tiết sản phẩm</label>
                        <textarea class="form-control" id="edit_detail" name="detail" rows="5"><?= $product_edit['detail'] ?></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Hiển thị modal chỉnh sửa khi trang được tải
    document.addEventListener('DOMContentLoaded', function() {
        var editProductModal = new bootstrap.Modal(document.getElementById('editProductModal'));
        editProductModal.show();
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