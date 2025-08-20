<?php
require_once 'models/AdminModel.php';
require_once 'models/ProductModel.php';

class AdminController {
    private $adminModel;
    private $productModel;
    
    public function __construct() {
        $this->adminModel = new AdminModel();
        $this->productModel = new ProductModel();
    }
    
    // Kiểm tra quyền admin
    private function checkAdminAccess() {
        // Kiểm tra session
        if (!isset($_SESSION['user'])) {
            // Session không tồn tại
            header('Location: index.php?act=login&error=no_session');
            exit;
        }
        
        // Kiểm tra quyền admin
        if ($_SESSION['user']['role'] !== 'admin') {
            // Không có quyền admin
            header('Location: index.php?act=login&error=not_admin&role=' . $_SESSION['user']['role']);
            exit;
        }
    }
    
    // Hiển thị trang dashboard
    public function Dashboard() {
        $this->checkAdminAccess();
        
        // Lấy thông tin thống kê
        $total_products = $this->productModel->getTotalProducts();
        $total_categories = count($this->productModel->getAllCategories());
        $total_users = $this->adminModel->getTotalUsers();
        
        // Hiển thị view
        include 'views/admin/dashboard.php';
    }
    
    // Quản lý sản phẩm
    public function ManageProducts() {
        $this->checkAdminAccess();
        
        // Lấy danh sách sản phẩm
        $products = $this->productModel->getAllProducts();
        $categories = $this->productModel->getAllCategories();
        
        // Kiểm tra nếu có id sản phẩm cần sửa
        $product_edit = null;
        if (isset($_GET['id'])) {
            $product_edit = $this->productModel->getProductById($_GET['id']);
            if (!$product_edit) {
                $_SESSION['error'] = 'Không tìm thấy sản phẩm!';
                header('Location: index.php?act=admin_products');
                exit;
            }
        }
        
        // Hiển thị view
        include 'views/admin/products.php';
    }
    
    // Thêm sản phẩm mới
    public function AddProduct() {
        $this->checkAdminAccess();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? 0;
            $description = $_POST['description'] ?? '';
            $detail = $_POST['detail'] ?? '';
            $category_id = $_POST['category_id'] ?? 0;
            $quantity = $_POST['quantity'] ?? 0;
            $discount = $_POST['discount'] ?? 0;
            
            // Xử lý upload hình ảnh
            $image = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $uploadDir = 'uploads/imgproduct/';
                
                // Tạo thư mục nếu chưa tồn tại
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $targetFile = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $image = $fileName;
                } else {
                    $_SESSION['error'] = 'Không thể upload hình ảnh!';
                    header('Location: index.php?act=admin_products');
                    exit;
                }
            } else {
                $_SESSION['error'] = 'Vui lòng chọn hình ảnh cho sản phẩm!';
                header('Location: index.php?act=admin_products');
                exit;
            }
            
            // Thêm sản phẩm vào database
            $result = $this->productModel->addProduct($name, $price, $description, $image, $category_id, $quantity, $discount, $detail);
            
            if ($result) {
                $_SESSION['success'] = 'Thêm sản phẩm thành công!';
               } else {
                $_SESSION['error'] = 'Thêm sản phẩm thất bại!';
            }
            
            header('Location: index.php?act=admin_products');
            exit;
        }
    }
    
    // Cập nhật sản phẩm
    public function UpdateProduct() {
        $this->checkAdminAccess();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? 0;
            $description = $_POST['description'] ?? '';
            $detail = $_POST['detail'] ?? '';
            $category_id = $_POST['category_id'] ?? 0;
            $quantity = $_POST['quantity'] ?? 0;
            $discount = $_POST['discount'] ?? 0;
            
            // Lấy thông tin sản phẩm hiện tại
            $currentProduct = $this->productModel->getProductById($id);
            
            if (!$currentProduct) {
                $_SESSION['error'] = 'Không tìm thấy sản phẩm!';
                header('Location: index.php?act=admin_products');
                exit;
            }
            
            // Xử lý upload hình ảnh
            $image = $currentProduct['image'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $uploadDir = 'uploads/imgproduct/';
                
                // Tạo thư mục nếu chưa tồn tại
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileName = time() . '_' . basename($_FILES['image']['name']);
                $targetFile = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                    $image = $fileName;
                    
                    // Xóa hình ảnh cũ nếu có
                    if (!empty($currentProduct['image'])) {
                        $oldImagePath = $uploadDir . $currentProduct['image'];
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                } else {
                    $_SESSION['error'] = 'Không thể upload hình ảnh!';
                    header('Location: index.php?act=admin_products');
                    exit;
                }
            }
            
            // Cập nhật sản phẩm trong database
            $result = $this->productModel->updateProduct($id, $name, $price, $description, $image, $category_id, $quantity, $discount, $detail);
            
            if ($result) {
                $_SESSION['success'] = 'Cập nhật sản phẩm thành công!';
            } else {
                $_SESSION['error'] = 'Cập nhật sản phẩm thất bại!';
            }
            
            header('Location: index.php?act=admin_products');
            exit;
        }
    }
    
    // Xóa sản phẩm
    public function DeleteProduct() {
        $this->checkAdminAccess();
        
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            // Lấy thông tin sản phẩm
            $product = $this->productModel->getProductById($id);
            
            // Xóa sản phẩm
            $result = $this->productModel->deleteProduct($id);
            
            if ($result) {
                // Xóa hình ảnh sản phẩm
                if (!empty($product['image'])) {
                    $imagePath = 'uploads/imgproduct/' . $product['image'];
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                
                $_SESSION['success'] = 'Xóa sản phẩm thành công!';
            } else {
                $_SESSION['error'] = 'Xóa sản phẩm thất bại!';
            }
        }
        
        header('Location: index.php?act=admin_products');
        exit;
    }
    
    // Quản lý danh mục
    public function ManageCategories() {
        $this->checkAdminAccess();
        
        // Lấy danh sách danh mục
        $categories = $this->productModel->getAllCategories();
        
        // Kiểm tra nếu có id danh mục cần sửa
        $category_edit = null;
        if (isset($_GET['id'])) {
            // Tìm danh mục theo id
            foreach ($categories as $category) {
                if ($category['id'] == $_GET['id']) {
                    $category_edit = $category;
                    break;
                }
            }
            
            if (!$category_edit) {
                $_SESSION['error'] = 'Không tìm thấy danh mục!';
                header('Location: index.php?act=admin_categories');
                exit;
            }
        }
        
        // Hiển thị view
        include 'views/admin/categories.php';
    }
    
    // Thêm danh mục mới
    public function AddCategory() {
        $this->checkAdminAccess();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            
            // Thêm danh mục vào database
            $result = $this->productModel->addCategory($name, $description);
            
            if ($result) {
                $_SESSION['success'] = 'Thêm danh mục thành công!';
            } else {
                $_SESSION['error'] = 'Thêm danh mục thất bại!';
            }
            
            header('Location: index.php?act=admin_categories');
            exit;
        }
    }
    
    // Cập nhật danh mục
    public function UpdateCategory() {
        $this->checkAdminAccess();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';
            
            // Cập nhật danh mục trong database
            $result = $this->productModel->updateCategory($id, $name, $description);
            
            if ($result) {
                $_SESSION['success'] = 'Cập nhật danh mục thành công!';
            } else {
                $_SESSION['error'] = 'Cập nhật danh mục thất bại!';
            }
            
            header('Location: index.php?act=admin_categories');
            exit;
        }
    }
    
    // Xóa danh mục
    public function DeleteCategory() {
        $this->checkAdminAccess();
        
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            // Kiểm tra xem danh mục có sản phẩm không
            $products = $this->productModel->getProductsByCategory($id);
            if (count($products) > 0) {
                $_SESSION['error'] = 'Không thể xóa danh mục này vì có sản phẩm thuộc danh mục!';
                header('Location: index.php?act=admin_categories');
                exit;
            }
            
            // Xóa danh mục
            $result = $this->productModel->deleteCategory($id);
            
            if ($result) {
                $_SESSION['success'] = 'Xóa danh mục thành công!';
            } else {
                $_SESSION['error'] = 'Xóa danh mục thất bại!';
            }
        }
        
        header('Location: index.php?act=admin_categories');
        exit;
    }
    

    
    // Quản lý người dùng
    public function ManageUsers() {
        $this->checkAdminAccess();
        
        $users = $this->adminModel->getAllUsers();
        $user_edit = null;
        if (isset($_GET['id'])) {
            $user_edit = $this->adminModel->getUserById($_GET['id']);
            
            if (!$user_edit) {
                $_SESSION['error'] = 'Không tìm thấy người dùng!';
                header('Location: index.php?act=admin_users');
                exit;
            }
        }
        
        // Hiển thị view
        include 'views/admin/users.php';
    }
    
    // Cập nhật thông tin người dùng
    public function UpdateUser() {
        $this->checkAdminAccess();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? 0;
            $username = $_POST['username'] ?? '';
            $fullname = $_POST['fullname'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $role = $_POST['role'] ?? 'customer';
            $password = $_POST['password'] ?? '';
            
            // Kiểm tra dữ liệu đầu vào
            if (empty($username) || empty($fullname) || empty($email)) {
                $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin bắt buộc!';
                header('Location: index.php?act=admin_users');
                exit;
            }
            
            // Kiểm tra email đã tồn tại chưa (nếu email thay đổi)
            $currentUser = $this->adminModel->getUserById($id);
            if ($currentUser && $email !== $currentUser['email']) {
                if ($this->adminModel->checkEmailExists($email)) {
                    $_SESSION['error'] = 'Email đã tồn tại!';
                    header('Location: index.php?act=admin_users');
                    exit;
                }
            }
            
            // Cập nhật thông tin người dùng
            if (!empty($password)) {
                
                $result = $this->adminModel->updateUserWithPassword($id, $username, $fullname, $email, $phone, $address, $role, $password);
            } else {
        
                $result = $this->adminModel->updateUser($id, $username, $fullname, $email, $phone, $address, $role);
            }
            
            if ($result) {
                $_SESSION['success'] = 'Cập nhật thông tin người dùng thành công!';
            } else {
                $_SESSION['error'] = 'Cập nhật thông tin người dùng thất bại!';
            }
            
            header('Location: index.php?act=admin_users');
            exit;
        }
    }
    
    // Xóa người dùng
    public function DeleteUser() {
        $this->checkAdminAccess();
        
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            // Không cho phép xóa tài khoản đang đăng nhập
            if ($_SESSION['user']['id'] == $id) {
                $_SESSION['error'] = 'Không thể xóa tài khoản đang đăng nhập!';
                header('Location: index.php?act=admin_users');
                exit;
            }
            
            // Xóa người dùng
            $result = $this->adminModel->deleteUser($id);
            
            if ($result) {
                $_SESSION['success'] = 'Xóa người dùng thành công!';
            } else {
                $_SESSION['error'] = 'Xóa người dùng thất bại!';
            }
        }
        
        header('Location: index.php?act=admin_users');
        exit;
    }
    
    // Thêm người dùng mới
    public function AddUser() {
        $this->checkAdminAccess();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $fullname = $_POST['fullname'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? '0';
            
            // Kiểm tra dữ liệu đầu vào
            if (empty($username) || empty($fullname) || empty($email) || empty($password)) {
                $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin bắt buộc!';
                header('Location: index.php?act=admin_users');
                exit;
            }
            
            // Kiểm tra username đã tồn tại chưa
            if ($this->adminModel->checkUserExists($username)) {
                $_SESSION['error'] = 'Tên đăng nhập đã tồn tại!';
                header('Location: index.php?act=admin_users');
                exit;
            }
            
            // Kiểm tra email đã tồn tại chưa
            if ($this->adminModel->checkEmailExists($email)) {
                $_SESSION['error'] = 'Email đã tồn tại!';
                header('Location: index.php?act=admin_users');
                exit;
            }
            
            // Thêm người dùng mới
            $result = $this->adminModel->addUser($username, $fullname, $email, $phone, $address, $password, $role);
            
            if ($result) {
                $_SESSION['success'] = 'Thêm người dùng thành công!';
            } else {
                $_SESSION['error'] = 'Thêm người dùng thất bại!';
            }
            
            header('Location: index.php?act=admin_users');
            exit;
        }
    }

}