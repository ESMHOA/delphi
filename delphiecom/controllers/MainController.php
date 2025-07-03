
<?php
class MainController {

    private $pdo;  
    private $cartModel;  

    public function __construct() {  
        require 'config/database.php';  
        $this->pdo = $pdo;  
        $this->cartModel = new Cart($this->pdo);  
    }  

    
    public function index() {
        $AmilNo= $_SESSION['AmilNo'];
        if (!isset($_SESSION['AmilNo'])) {
            header('Location: index.php');
            exit();

        }
        require 'views/main.php';
            // حساب إجمالي الفاتورة وعدد الأصناف  
            $totalAmount =$this-> cartModel->getTotalAmount($AmilNo);  
            $totalItems = $this->cartModel->getTotalItems($AmilNo);  
            $_SESSION['totalAmount'] = $totalAmount;
            $_SESSION['totalItems'] = $totalItems;

    }
}
?>
