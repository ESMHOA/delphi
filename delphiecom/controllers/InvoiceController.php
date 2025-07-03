
<?php
class InvoiceController {
    private $pdo;
    private $cartModel;

    public function __construct() {
        require 'config/database.php';
        $this->pdo = $pdo;
        $this->cartModel = new Cart($this->pdo);
    }

    public function index() {
        if (!isset($_SESSION['AmilNo'])) {
            header('Location: index.php');
            exit();
        }

        $AmilNo = $_SESSION['AmilNo'];
        $cartItems = $this->cartModel->getCartItems($AmilNo);
        require 'views/invoice.php';


    
    }

    public function updateItem() {
        $AmilNo = $_SESSION['AmilNo'];
        $SenfNo = $_POST['SenfNo'];
        $Q = $_POST['Q'];

        $this->cartModel->updateItem($AmilNo, $SenfNo, $Q);
        header('Location: index.php?controller=invoice&action=index');

                // حساب إجمالي الفاتورة وعدد الأصناف  
                $totalAmount =$this-> cartModel->getTotalAmount($AmilNo);  
                $totalItems = $this->cartModel->getTotalItems($AmilNo);  
                $_SESSION['totalAmount'] = $totalAmount;
                $_SESSION['totalItems'] = $totalItems;
        
    }

    public function deleteItem() {
        $AmilNo = $_SESSION['AmilNo'];
        $SenfNo = $_GET['SenfNo'];

        $this->cartModel->deleteItem($AmilNo, $SenfNo);
        header('Location: index.php?controller=invoice&action=index');

                // حساب إجمالي الفاتورة وعدد الأصناف  
                $totalAmount =$this-> cartModel->getTotalAmount($AmilNo);  
                $totalItems = $this->cartModel->getTotalItems($AmilNo);  
                $_SESSION['totalAmount'] = $totalAmount;
                $_SESSION['totalItems'] = $totalItems;

    }
    public function completePurchase() {  
        // تأكد من أن الجلسة قد بدأت  
        session_start();  
        
        // تحديث الحقل done في جدول Cart إلى 1  
        $stmt = $this->pdo->prepare("UPDATE Cart SET done = 1 WHERE AmilNo = ?");  
        $stmt->execute([$_SESSION['AmilNo']]);  
        
        // إعادة توجيه المستخدم إلى صفحة الفاتورة أو أي صفحة أخرى  
        header('Location: index.php?controller=invoice&action=index');  
        exit();  
    }

    public function openCart() {  
        // تأكد من أن الجلسة قد بدأت  
        session_start();  
        
        // تحديث الحقل done في جدول Cart إلى 0  
        $stmt = $this->pdo->prepare("UPDATE Cart SET done = 0 WHERE AmilNo = ?");  
        $stmt->execute([$_SESSION['AmilNo']]);  
        
        // إعادة توجيه المستخدم إلى صفحة الفاتورة أو أي صفحة أخرى  
        header('Location: index.php?controller=invoice&action=index');  
        exit();  
    }

}
?>
