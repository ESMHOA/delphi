<?php  
class Cart {  
    private $pdo;  

    public function __construct($pdo) {  
        $this->pdo = $pdo;  
    }  

    public function addItem($AmilNo, $SenfNo, $Q, $Price) {  
        // تحقق إذا كان الصنف موجودًا في السلة  
        $stmt = $this->pdo->prepare("SELECT * FROM Cart WHERE AmilNo = ? AND SenfNo = ?");  
        $stmt->execute([$AmilNo, $SenfNo]);  
        $item = $stmt->fetch();  

        if ($item) {  
            // تحديث الكمية  
            $newQuantity = $item['Q'] + $Q;  
            $stmt = $this->pdo->prepare("UPDATE Cart SET Q = ? WHERE AmilNo = ? AND SenfNo = ?");  
            $stmt->execute([$newQuantity, $AmilNo, $SenfNo]);  
        } else {  
            // إضافة صنف جديد  
            $date = new DateTime();  
            $formattedDate = $date->format('Y-m-d H:i:s'); // تنسيق التاريخ والوقت  
            
            $stmt = $this->pdo->prepare("INSERT INTO Cart (AmilNo, SenfNo, Q, Price, EnteredDate) VALUES (?, ?, ?, ?, ?)");  
            $stmt->execute([$AmilNo, $SenfNo, $Q, $Price, $formattedDate]); // تمرير التاريخ المنسق            
        }  
    }  

    public function getCartItems($AmilNo) {  
        $stmt = $this->pdo->prepare("SELECT Cart.*, kamkrt.SenfDisc FROM Cart JOIN kamkrt ON Cart.SenfNo = kamkrt.SenfNo WHERE Cart.AmilNo = ?");  
        $stmt->execute([$AmilNo]);  
        return $stmt->fetchAll();  
    }  

    public function updateItem($AmilNo, $SenfNo, $Q) {  
        $stmt = $this->pdo->prepare("UPDATE Cart SET Q = ? WHERE AmilNo = ? AND SenfNo = ?");  
        $stmt->execute([$Q, $AmilNo, $SenfNo]);  
    }  

    public function deleteItem($AmilNo, $SenfNo) {  
        $stmt = $this->pdo->prepare("DELETE FROM Cart WHERE AmilNo = ? AND SenfNo = ?");  
        $stmt->execute([$AmilNo, $SenfNo]);  
    }  

       // دالة لحساب إجمالي الفاتورة  
       public function getTotalAmount($AmilNo) {  
        $stmt = $this->pdo->prepare("SELECT SUM(Q * Price) AS totalAmount FROM Cart WHERE AmilNo = ?");  
        $stmt->execute([$AmilNo]);  
        $result = $stmt->fetch(); 
        // تخزين القيمة في الجلسة  
        $_SESSION['totalAmount'] = $result['totalAmount'] ? $result['totalAmount'] : 0;  

            // إرجاع القيمة  
        return $_SESSION['totalAmount'];           
       // return $result['totalAmount'] ? $result['totalAmount'] : 0;  
    }  

    // دالة لحساب عدد الأصناف  
    public function getTotalItems($AmilNo) {  
        $stmt = $this->pdo->prepare("SELECT SUM(Q) AS totalItems FROM Cart WHERE AmilNo = ?");  
        $stmt->execute([$AmilNo]);  
        $result = $stmt->fetch();  
        return $result['totalItems'] ? $result['totalItems'] : 0;  
    }  

}  
?>