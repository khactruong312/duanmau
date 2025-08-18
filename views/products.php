<?php
// Lấy dữ liệu từ controller
$products = $products ?? [];
$categories = $categories ?? [];

// Include header
require_once 'layout/header.php';
?>

<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tất cả sản phẩm</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar danh mục -->
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Danh mục sản phẩm</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item active">
                            <a href="index.php?act=products" class="text-white">Tất cả sản phẩm</a>
                        </li>
                        <?php foreach ($categories as $category): ?>
                        <li class="list-group-item">
                            <a href="index.php?act=category&id=<?= $category['id'] ?>" class="text-dark">
                                <?= $category['name'] ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="col-md-9">
            <h2 class="mb-4">Tất cả sản phẩm</h2>
            
            <?php if (empty($products)): ?>
            <div class="alert alert-info">
                Không có sản phẩm nào.
            </div>
            <?php else: ?>
            <div class="row">
                <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card product-card h-100">
                        <img src="uploads/imgproduct/<?= $product['image'] ?>" class="card-img-top" alt="<?= $product['name'] ?>" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?= $product['name'] ?></h5>
                            <p class="card-text text-danger fw-bold"><?= number_format($product['price'], 0, ',', '.') ?> đ</p>
                            <div class="d-flex justify-content-between">
                                <a href="index.php?act=detail&id=<?= $product['id'] ?>" class="btn btn-sm btn-primary">Chi tiết</a>
                            </div>
                        </div>
                    </div>  
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
// Include footer
require_once 'layout/footer.php';
?>