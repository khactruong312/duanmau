<?php
// Lấy dữ liệu từ controller
$categories = $categories ?? [];
$products = $products ?? [];

// Include header
require_once 'layout/header.php';
?>

<!-- Banner -->
<div class="banner" style="background-image: url('https://images.unsplash.com/photo-1607082350899-7e105aa886ae?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-md-6">
                <div class="bg-dark bg-opacity-75 p-4 rounded text-white">
                    <h1>Chào mừng đến với Shop Bán Hàng</h1>
                    <p class="lead">Khám phá các sản phẩm chất lượng cao với giá cả hợp lý</p>
                    <a href="index.php?act=products" class="btn btn-primary">Xem sản phẩm</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Danh mục sản phẩm -->
<section class="mb-5">
    <h2 class="text-center mb-4">Danh mục sản phẩm</h2>
    <div class="row">
        <?php foreach ($categories as $category): ?>
        <div class="col-md-3 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <h5 class="card-title"><?= $category['name'] ?></h5>
                    <p class="card-text"><?= $category['description'] ?></p>
                    <a href="index.php?act=category&id=<?= $category['id'] ?>" class="btn btn-outline-primary">Xem sản phẩm</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Sản phẩm nổi bật -->
<section>
    <h2 class="text-center mb-4">Sản phẩm nổi bật</h2>
    <div class="row">
        <?php foreach (array_slice($products, 0, 8) as $product): ?>
        <div class="col-md-3">
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
    <div class="text-center mt-4">
        <a href="index.php?act=products" class="btn btn-outline-primary">Xem tất cả sản phẩm</a>
    </div>
</section>

<?php
// Include footer
require_once 'layout/footer.php';
?>
