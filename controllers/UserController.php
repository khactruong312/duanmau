<?php
class UserController
{
    public $modelUser;

    public function __construct()
    {
        $this->modelUser = new UserModel();
    }

    // Hiển thị trang đăng nhập
    public function Login()
    {
        // Nếu đã đăng nhập thì chuyển hướng về trang chủ
        if (isset($_SESSION['user'])) {
            header('Location: index.php');
            exit;
        }

        $error = '';

        // Xử lý đăng nhập
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            // Kiểm tra các trường bắt buộc
            if (empty($username) || empty($password)) {
                $error = 'Vui lòng nhập tên đăng nhập và mật khẩu!';
            } else {
                // Kiểm tra đăng nhập
                $user = $this->modelUser->checkLogin($username, $password);

                if ($user) {
                    // Lưu thông tin người dùng vào session
                    $_SESSION['user'] = $user;

                    // Chuyển hướng dựa vào vai trò
                    if ($user['role'] == 'admin') {
                        header('Location: index.php?act=admin');
                    } else {
                        header('Location: index.php');
                    }
                    exit;
                } else {
                    $error = 'Tên đăng nhập hoặc mật khẩu không đúng!';
                }
            }
        }

        require_once __DIR__ . '/../views/login.php';
    }

    // Hiển thị trang đăng ký
    public function Register()
    {
        // Nếu đã đăng nhập thì chuyển hướng về trang chủ
        if (isset($_SESSION['user'])) {
            header('Location: index.php');
            exit;
        }

        $error = '';
        $success = '';

        // Xử lý đăng ký
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $fullname = $_POST['fullname'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            // Kiểm tra các trường bắt buộc
            if (empty($username) || empty($fullname) || empty($email) || empty($password) || empty($confirm_password)) {
                $error = 'Vui lòng điền đầy đủ thông tin bắt buộc!';
            }
            // Kiểm tra mật khẩu xác nhận
            else if ($password !== $confirm_password) {
                $error = 'Mật khẩu xác nhận không khớp!';
            } 
            // Kiểm tra username và email đã tồn tại chưa
            else if ($this->modelUser->checkUserExists($username, $email)) {
                $error = 'Tên đăng nhập hoặc email đã tồn tại!';
            } 
            else {
                // Thêm người dùng mới với các trường đơn giản hóa
                $result = $this->modelUser->addUser($username, $fullname, $email, '', '', $password);

                if ($result) {
                    // Đăng ký thành công, chuyển hướng đến trang đăng nhập với thông báo thành công
                    $_SESSION['success'] = 'Đăng ký thành công! Vui lòng đăng nhập.';
                    header('Location: index.php?act=login');
                    exit;
                } else {
                    $error = 'Đăng ký thất bại! Vui lòng thử lại.';
                }
            }
        }

        require_once __DIR__ . '/../views/register.php';
    }

    // Đăng xuất
    public function Logout()
    {
        // Xóa session
        unset($_SESSION['user']);
        session_destroy();

        // Chuyển hướng về trang chủ
        header('Location: index.php');
        exit;
    }

    // Hiển thị trang thông tin cá nhân
    public function Profile()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?act=login');
            exit;
        }

        $user = $_SESSION['user'];
        $error = '';
        $success = '';

        // Xử lý cập nhật thông tin
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullname = $_POST['fullname'] ?? '';
            $email = $_POST['email'] ?? '';
            $phone = $_POST['phone'] ?? '';
            $address = $_POST['address'] ?? '';
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            // Kiểm tra email đã tồn tại chưa (nếu thay đổi email)
            if ($email !== $user['email'] && $this->modelUser->checkEmailExists($email)) {
                $error = 'Email đã tồn tại!';
            } else {
                // Nếu người dùng muốn đổi mật khẩu
                if (!empty($current_password) && !empty($new_password)) {
                    // Kiểm tra mật khẩu hiện tại
                    if (!$this->modelUser->verifyPassword($user['id'], $current_password)) {
                        $error = 'Mật khẩu hiện tại không đúng!';
                    } else if ($new_password !== $confirm_password) {
                        $error = 'Mật khẩu xác nhận không khớp!';
                    } else {
                        // Cập nhật thông tin và mật khẩu
                        $result = $this->modelUser->updateUserWithPassword($user['id'], $fullname, $email, $phone, $address, $new_password);

                        if ($result) {
                            // Cập nhật lại session
                            $_SESSION['user'] = $this->modelUser->getUserById($user['id']);
                            $success = 'Cập nhật thông tin thành công!';
                        } else {
                            $error = 'Cập nhật thông tin thất bại!';
                        }
                    }
                } else {
                    // Chỉ cập nhật thông tin cá nhân
                    $result = $this->modelUser->updateUser($user['id'], $fullname, $email, $phone, $address);

                    if ($result) {
                        // Cập nhật lại session
                        $_SESSION['user'] = $this->modelUser->getUserById($user['id']);
                        $success = 'Cập nhật thông tin thành công!';
                    } else {
                        $error = 'Cập nhật thông tin thất bại!';
                    }
                }
            }
        }

        require_once __DIR__ . '/../views/profile.php';
    }


}