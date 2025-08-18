<?php
class UserModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Kiểm tra đăng nhập
    public function checkLogin($username, $password)
    {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        // Kiểm tra nếu mật khẩu đã được hash
        if ($user && (password_verify($password, $user['password']) || $password === $user['password'])) {
            // Loại bỏ mật khẩu trước khi trả về
            unset($user['password']);
            return $user;
        }

        return false;
    }

    // Kiểm tra username hoặc email đã tồn tại chưa
    public function checkUserExists($username, $email)
    {
        $sql = "SELECT COUNT(*) FROM users WHERE username = ? OR email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$username, $email]);
        return $stmt->fetchColumn() > 0;
    }

    // Kiểm tra email đã tồn tại chưa
    public function checkEmailExists($email)
    {
        $sql = "SELECT COUNT(*) FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    // Thêm người dùng mới
    public function addUser($username, $fullname, $email, $phone, $address, $password)
    {
        // Mã hóa mật khẩu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, fullname, email, phone, address, password, role, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $username,
            $fullname,
            $email,
            $phone,
            $address,
            $hashed_password,
            'customer', // Vai trò mặc định là người dùng thường
            date('Y-m-d H:i:s')
        ]);
    }

    // Lấy thông tin người dùng theo ID
    public function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        $user = $stmt->fetch();

        if ($user) {
            // Loại bỏ mật khẩu trước khi trả về
            unset($user['password']);
        }

        return $user;
    }

    // Kiểm tra mật khẩu
    public function verifyPassword($user_id, $password)
    {
        $sql = "SELECT password FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$user_id]);
        $hash = $stmt->fetchColumn();

        return password_verify($password, $hash);
    }

    // Cập nhật thông tin người dùng (không bao gồm mật khẩu)
    public function updateUser($id, $fullname, $email, $phone, $address)
    {
        $sql = "UPDATE users SET fullname = ?, email = ?, phone = ?, address = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$fullname, $email, $phone, $address, $id]);
    }

    // Cập nhật thông tin người dùng (bao gồm mật khẩu)
    public function updateUserWithPassword($id, $fullname, $email, $phone, $address, $password)
    {
        // Mã hóa mật khẩu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET fullname = ?, email = ?, phone = ?, address = ?, password = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$fullname, $email, $phone, $address, $hashed_password, $id]);
    }
}