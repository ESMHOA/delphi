
<?php
class Item {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllItems($priceField, $searchQuery) {  
        $query = "SELECT SenfNo, SenfDisc, $priceField AS Price, Unit, Obowwa FROM kamkrt";  
        
        if (!empty($searchQuery)) {  
            // إضافة شرط البحث إلى الاستعلام  
            $query .= " WHERE SenfDisc LIKE :search";  
        }  
    
        $stmt = $this->pdo->prepare($query);  
        
        if (!empty($searchQuery)) {  
            $stmt->bindValue(':search', '%' . $searchQuery . '%');  
        }  
    
        $stmt->execute();  
        return $stmt->fetchAll();  
    }
        public function getItemById($SenfNo, $priceField) {
        $stmt = $this->pdo->prepare("SELECT SenfNo, SenfDisc, $priceField AS Price FROM kamkrt WHERE SenfNo = ?");
        $stmt->execute([$SenfNo]);
        return $stmt->fetch();
    }
}
?>
