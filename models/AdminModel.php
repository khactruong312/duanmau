<?php
class AdminModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }
    
    // Kiểm tra username đã tồn tại chưa
    public function checkUserExists($username) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }
    
    // Kiểm tra email đã tồn tại chưa
    public function checkEmailExists($email) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] > 0;
    }

    // Lấy thống kê tổng quan
    public function getStats() {
        $stats = [];
        
        // Tổng số sản phẩm
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM products");
        $stmt->execute();
        $stats['total_products'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Tổng số danh mục
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM categories");
        $stmt->execute();
        $stats['total_categories'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Tổng số người dùng
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM users");
        $stmt->execute();
        $stats['total_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        return $stats;
    }
    
    // Lấy tổng số người dùng
    public function getTotalUsers() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as total FROM users");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ? $result['total'] : 0;
    }


    // Lấy danh sách tất cả người dùng
    public function getAllUsers() {
        $stmt = $this->conn->prepare("SELECT * FROM users ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Lấy thông tin người dùng theo ID
    public function getUserById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Cập nhật thông tin người dùng (không cập nhật mật khẩu)
    public function updateUser($id, $username, $fullname, $email, $phone, $address, $role) {
        $stmt = $this->conn->prepare("UPDATE users SET username = ?, fullname = ?, email = ?, phone = ?, address = ?, role = ? WHERE id = ?");
        return $stmt->execute([$username, $fullname, $email, $phone, $address, $role, $id]);
    }
    
    // Cập nhật thông tin người dùng (có cập nhật mật khẩu)
    public function updateUserWithPassword($id, $username, $fullname, $email, $phone, $address, $role, $password) {
        // Mã hóa mật khẩu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $stmt = $this->conn->prepare("UPDATE users SET username = ?, fullname = ?, email = ?, phone = ?, address = ?, role = ?, password = ? WHERE id = ?");
        return $stmt->execute([$username, $fullname, $email, $phone, $address, $role, $hashed_password, $id]);
    }
    
    // Xóa người dùng
    public function deleteUser($id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
    
    // Thêm người dùng mới
    public function addUser($username, $fullname, $email, $phone, $address, $password, $role) {
        // Mã hóa mật khẩu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Thêm người dùng vào database
        $stmt = $this->conn->prepare("INSERT INTO users (username, fullname, email, phone, address, password, role, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
        return $stmt->execute([$username, $fullname, $email, $phone, $address, $hashed_password, $role]);
    }
}