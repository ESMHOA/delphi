<?php  
class StoreController {  
    private $pdo;  
    private $itemModel;  
    private $cartModel;  

    public function __construct() {  
        require 'config/database.php';  
        $this->pdo = $pdo;  
        $this->itemModel = new Item($this->pdo);  
        $this->cartModel = new Cart($this->pdo);  
    }  

    public function index() {  
        if (!isset($_SESSION['AmilNo'])) {  
            header('Location: index.php');  
            exit();  
        }  
    
        $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';  
    
        // تحديد السعر بناءً على PuyType  
        switch ($_SESSION['PuyType']) {  
            case 1:  
                $priceField = 'PuyKetaey';  
                break;  
            case 2:  
                $priceField = 'PuyJomla1';  
                break;  
            case 3:  
                $priceField = 'PuyJomla2';  
                break;  
            case 4:  
                $priceField = 'NawPrice';  
                break;  
            default:  
                $priceField = 'PuyKetaey';  
        }  
    
        $items = $this->itemModel->getAllItems($priceField, $searchQuery);  
        require 'views/store.php';  
    }  

    public function addToCart() {  
        $AmilNo = $_SESSION['AmilNo'];  
        $SenfNo = $_GET['SenfNo'];  
        $Q = isset($_POST['Q']) ? $_POST['Q'] : 1;  

        // تحديد السعر بناءً على PuyType  
        switch ($_SESSION['PuyType']) {  
            case 1:  
                $priceField = 'PuyKetaey';  
                break;  
            case 2:  
                $priceField = 'PuyJomla1';  
                break;  
            case 3:  
                $priceField = 'PuyJomla2';  
                break;  
            case 4:  
                $priceField = 'NawPrice';  
                break;  
            default:  
                $priceField = 'PuyKetaey';  
        }  

        $item = $this->itemModel->getItemById($SenfNo, $priceField);  

        if ($item) {  
            $Price = $item['Price'];  
            $this->cartModel->addItem($AmilNo, $SenfNo, $Q, $Price);  

            // حساب إجمالي الفاتورة وعدد الأصناف  
            $totalAmount = $this->cartModel->getTotalAmount($AmilNo);  
            $totalItems  = $this->cartModel->getTotalItems($AmilNo);  
            $_SESSION['totalAmount'] = $totalAmount;
            $_SESSION['totalItems'] = $totalItems;
  
            echo json_encode(['success' => true, 'totalAmount' => $totalAmount, 'totalItems' => $totalItems]);  
        } else {  
            echo json_encode(['success' => false, 'message' => "الصنف غير موجود."]);  
        }  
    }  
}  
?>