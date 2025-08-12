<?php
// Lấy dữ liệu từ controller
$product = $product ?? [];
$categories = $categories ?? [];

// Include header
require_once 'layout/header.php';
?>

<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="index.php?act=category&id=<?= $product['category_id'] ?>">Danh mục</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= $product['name'] ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Hình ảnh sản phẩm -->
        <div class="col-md-5">
            <div class="card">
                <img src="uploads/imgproduct/<?= $product['image'] ?>" class="card-img-top" alt="<?= $product['name'] ?>" style="height: 400px; object-fit: contain;">
            </div>
        </div>

        <!-- Thông tin sản phẩm -->
        <div class="col-md-7">
            <h1 class="mb-3"><?= $product['name'] ?></h1>
            <div class="d-flex align-items-center mb-3">
                <div class="text-warning me-2">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <span>(4.5/5 - 120 đánh giá)</span>
            </div>
            <h2 class="text-danger mb-4"><?= number_format($product['price'], 0, ',', '.') ?> đ</h2>
            <p class="mb-4"><?= $product['description'] ?></p>

            <div class="mb-4">
                <button type="button" class="btn btn-outline-danger"><i class="fas fa-heart me-2"></i>Yêu thích</button>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Thông tin giao hàng</h5>
                    <p class="card-text"><i class="fas fa-truck me-2"></i>Giao hàng miễn phí cho đơn hàng từ 500.000đ</p>
                    <p class="card-text"><i class="fas fa-undo me-2"></i>Đổi trả trong vòng 30 ngày</p>
                    <p class="card-text"><i class="fas fa-shield-alt me-2"></i>Bảo hành 12 tháng chính hãng</p>
                </div>
            </div>

            <div class="d-flex align-items-center">
                <span class="me-3">Chia sẻ:</span>
                <a href="#" class="text-primary me-2"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-info me-2"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-danger me-2"><i class="fab fa-pinterest"></i></a>
                <a href="#" class="text-success"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>
    </div>

    <!-- Mô tả chi tiết -->
    <div class="row mt-5">
        <div class="col-12">
            <ul class="nav nav-tabs" id="productTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab">Mô tả chi tiết</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab">Thông số kỹ thuật</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">Đánh giá (120)</button>
                </li>
            </ul>
            <div class="tab-content p-4 border border-top-0 rounded-bottom" id="productTabContent">
                <div class="tab-pane fade show active" id="description" role="tabpanel">
                    <p><?= $product['description'] ?></p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
                <div class="tab-pane fade" id="specs" role="tabpanel">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th scope="row">Thương hiệu</th>
                                <td>Brand XYZ</td>
                            </tr>
                            <tr>
                                <th scope="row">Xuất xứ</th>
                                <td>Việt Nam</td>
                            </tr>
                            <tr>
                                <th scope="row">Bảo hành</th>
                                <td>12 tháng</td>
                            </tr>
                            <tr>
                                <th scope="row">Kích thước</th>
                                <td>10 x 15 x 5 cm</td>
                            </tr>
                            <tr>
                                <th scope="row">Trọng lượng</th>
                                <td>500g</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="reviews" role="tabpanel">
                    <div class="mb-4">
                        <h5>Đánh giá sản phẩm</h5>
                        <div class="d-flex align-items-center mb-2">
                            <div class="text-warning me-2">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                            <span>4.5/5 (120 đánh giá)</span>
                        </div>
                        <div class="progress mb-1" style="height: 10px;">
                            <div class="progress-bar bg-warning" style="width: 80%;">5 sao (80%)</div>
                        </div>
                        <div class="progress mb-1" style="height: 10px;">
                            <div class="progress-bar bg-warning" style="width: 15%;">4 sao (15%)</div>
                        </div>
                        <div class="progress mb-1" style="height: 10px;">
                            <div class="progress-bar bg-warning" style="width: 3%;">3 sao (3%)</div>
                        </div>
                        <div class="progress mb-1" style="height: 10px;">
                            <div class="progress-bar bg-warning" style="width: 1%;">2 sao (1%)</div>
                        </div>
                        <div class="progress mb-1" style="height: 10px;">
                            <div class="progress-bar bg-warning" style="width: 1%;">1 sao (1%)</div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Viết đánh giá</h5>
                        <form>
                            <div class="mb-3">
                                <label for="rating" class="form-label">Đánh giá của bạn</label>
                                <select class="form-select" id="rating">
                                    <option value="5">5 sao - Xuất sắc</option>
                                    <option value="4">4 sao - Tốt</option>
                                    <option value="3">3 sao - Bình thường</option>
                                    <option value="2">2 sao - Kém</option>
                                    <option value="1">1 sao - Rất kém</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="reviewTitle" class="form-label">Tiêu đề</label>
                                <input type="text" class="form-control" id="reviewTitle">
                            </div>
                            <div class="mb-3">
                                <label for="reviewContent" class="form-label">Nội dung</label>
                                <textarea class="form-control" id="reviewContent" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Gửi đánh giá</button>
                        </form>
                    </div>

                    <div class="border-top pt-4">
                        <h5>Đánh giá từ khách hàng</h5>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <h6 class="card-title">Nguyễn Văn A</h6>
                                    <small class="text-muted">2 ngày trước</small>
                                </div>
                                <div class="text-warning mb-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                                <h6>Sản phẩm tuyệt vời</h6>
                                <p class="card-text">Tôi rất hài lòng với sản phẩm này. Chất lượng tốt, giao hàng nhanh.</p>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <h6 class="card-title">Trần Thị B</h6>
                                    <small class="text-muted">1 tuần trước</small>
                                </div>
                                <div class="text-warning mb-2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star"></i>
                                </div>
                                <h6>Khá tốt</h6>
                                <p class="card-text">Sản phẩm đúng như mô tả, tuy nhiên đóng gói hơi sơ sài.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sản phẩm liên quan -->
    <section class="mt-5">
        <h3 class="text-center mb-4">Sản phẩm liên quan</h3>
        <div class="row">
            <?php for ($i = 0; $i < 4; $i++): ?>
            <div class="col-md-3">
                <div class="card product-card h-100">
                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Sản phẩm liên quan">
                    <div class="card-body">
                        <h5 class="card-title">Sản phẩm liên quan <?= $i + 1 ?></h5>
                        <p class="card-text text-danger fw-bold"><?= number_format(rand(100000, 5000000), 0, ',', '.') ?> đ</p>
                        <div class="d-flex justify-content-between">
                            <a href="#" class="btn btn-sm btn-primary">Chi tiết</a>
                            <a href="#" class="btn btn-sm btn-success">Thêm vào giỏ</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </section>
</div>

<?php
// Include footer
require_once 'layout/footer.php';
?>