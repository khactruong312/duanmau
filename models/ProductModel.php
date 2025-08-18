<?php
class ProductModel
{
    public $conn;
    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy tất cả danh mục
    public function getAllCategories()
    {
        $sql = "SELECT * FROM categories";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy tất cả sản phẩm với thông tin danh mục
    public function getAllProducts()
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                ORDER BY p.id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Lấy chi tiết sản phẩm
    public function getProductById($id)
    {
        $sql = "SELECT p.*, c.name as category_name 
                FROM products p 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    // Thêm sản phẩm mới
   public function addProduct($name, $price, $description, $image, $category_id, $quantity, $discount, $detail = ''): bool
{
    $sql = "INSERT INTO products 
            (name, price, description, image, category_id, discount, quantity) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([
        $name,
        $price,
        $description,
        $image,
        $category_id,
        $discount,
        $quantity
    ]);
}

    
    // Cập nhật sản phẩm
 public function updateProduct($id, $name, $price, $description, $image, $category_id, $discount) {
    $sql = "UPDATE products 
            SET name=?, price=?, description=?, image=?, category_id=?, discount=? 
            WHERE id=?";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([$name, $price, $description, $image, $category_id, $discount, $id]);
}


    
    // Xóa sản phẩm
    public function deleteProduct($id)
    {
        $sql = "DELETE FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
    
    // Lấy tổng số sản phẩm
    public function getTotalProducts()
    {
        $sql = "SELECT COUNT(*) as total FROM products";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }
    
    // Lấy sản phẩm theo danh mục
    public function getProductsByCategory($category_id)
    {
        $sql = "SELECT * FROM products WHERE category_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$category_id]);
        return $stmt->fetchAll();
    }
    
    // Thêm danh mục mới
    public function addCategory($name, $description = '')
    {
        $sql = "INSERT INTO categories (name, description) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$name, $description]);
    }
    
    // Cập nhật danh mục
    public function updateCategory($id, $name, $description = '')
    {
        $sql = "UPDATE categories SET name = ?, description = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$name, $description, $id]);
    }
    
    // Xóa danh mục
    public function deleteCategory($id)
    {
        $sql = "DELETE FROM categories WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$id]);
    }
}
