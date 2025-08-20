<?php
// có class chứa các function thực thi xử lý logic 
class ProductController
{
    public $modelProduct;

    public function __construct()
    {
        $this->modelProduct = new ProductModel();
    }

    public function Home()
    {
        // Lấy danh sách danh mục
        $categories = $this->modelProduct->getAllCategories();
        
        // Lấy danh sách sản phẩm
        $products = $this->modelProduct->getAllProducts();
        
        // Hiển thị view
        require_once './views/trangchu.php';
    }
    
    public function Detail()
    {
        // Kiểm tra id sản phẩm
        $id = $_GET['id'] ?? 0;
        
        // Lấy thông tin sản phẩm
        $product = $this->modelProduct->getProductById($id);
        
        // Nếu không tìm thấy sản phẩm thì chuyển hướng về trang chủ
        if (!$product) {
            header('Location: index.php');
            exit;
        }
        
        // Lấy danh sách danh mục
        $categories = $this->modelProduct->getAllCategories();
        
        // Hiển thị view
        require_once './views/detail.php';
    }
    
    public function Category()
    {
        // Kiểm tra id danh mục
        $id = $_GET['id'] ?? 0;
        
        // Lấy danh sách sản phẩm theo danh mục
        $products = $this->modelProduct->getProductsByCategory($id);
        
        // Lấy danh sách danh mục
        $categories = $this->modelProduct->getAllCategories();
        
        // Tìm thông tin danh mục hiện tại
        $current_category = null;
        foreach ($categories as $category) {
            if ($category['id'] == $id) {
                $current_category = $category;
                break;
            }
        }
        
        // Hiển thị view
        require_once './views/category.php';
    }
    
    public function AllProducts()
    {
        $products = $this->modelProduct->getAllProducts();
        $categories = $this->modelProduct->getAllCategories();
        require_once './views/products.php';
    }
}
