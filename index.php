<?php 
// Require toàn bộ các file khai báo môi trường, thực thi,...(không require view)

// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
require_once './controllers/ProductController.php';
require_once './controllers/UserController.php';
require_once './controllers/AdminController.php';

// Require toàn bộ file Models
require_once './models/ProductModel.php';
require_once './models/UserModel.php';
require_once './models/AdminModel.php';

// Route
$act = $_GET['act'] ?? '/';


// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {
    // Trang chủ
    '/'=>(new ProductController())->Home(),
    
    // Sản phẩm
    'detail'=>(new ProductController())->Detail(),
    'category'=>(new ProductController())->Category(),
    'products'=>(new ProductController())->AllProducts(),
    
    // Người dùng
    'login'=>(new UserController())->Login(),
    'register'=>(new UserController())->Register(),
    'logout'=>(new UserController())->Logout(),
    'profile'=>(new UserController())->Profile(),
    
    // Admin
    'admin'=>(new AdminController())->Dashboard(),
    'admin_products'=>(new AdminController())->ManageProducts(),
    'admin_products_add'=>(new AdminController())->AddProduct(),
    'admin_products_update'=>(new AdminController())->UpdateProduct(),
    'admin_products_delete'=>(new AdminController())->DeleteProduct(),
    'admin_categories'=>(new AdminController())->ManageCategories(),
    'admin_add_category'=>(new AdminController())->AddCategory(),
    'admin_update_category'=>(new AdminController())->UpdateCategory(),
    'admin_delete_category'=>(new AdminController())->DeleteCategory(),
    'admin_users'=>(new AdminController())->ManageUsers(),
    'admin_users_add'=>(new AdminController())->AddUser(),
    'admin_users_update'=>(new AdminController())->UpdateUser(),
    'admin_users_delete'=>(new AdminController())->DeleteUser(),
    
    // Mặc định
    default => (new ProductController())->Home(),
};