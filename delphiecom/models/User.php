
<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function login($AmilNo, $Passworda) {
        $stmt = $this->pdo->prepare("SELECT * FROM amilkrt WHERE AmilNo = ? AND PassWord = ?");
        $stmt->execute([$AmilNo, $Passworda]);
        return $stmt->fetch();
    }
    // دالة لحساب إجمالي الفاتورة  
    public function getTotalAmountUser($AmilNo) {  
        $stmt = $this->pdo->prepare("SELECT SUM(Q * Price) AS totalAmount FROM Cart WHERE AmilNo = ?");  
        $stmt->execute([$AmilNo]);  
        $result = $stmt->fetch();  
        return $result['totalAmount'] ? $result['totalAmount'] : 0;  
    }  

    // دالة لحساب عدد الأصناف  
    public function getTotalItemsUser($AmilNo) {  
        $stmt = $this->pdo->prepare("SELECT SUM(Q) AS totalItems FROM Cart WHERE AmilNo = ?");  
        $stmt->execute([$AmilNo]);  
        $result = $stmt->fetch();  
        return $result['totalItems'] ? $result['totalItems'] : 0;  
    }  

}
?>
