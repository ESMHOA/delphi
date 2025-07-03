<?php  
include 'config/database.php'; // تأكد من تضمين ملف الاتصال بقاعدة البيانات  

// تحقق مما إذا كان المستخدم مسجلاً للدخول  
if (isset($_SESSION['AmilNo'])) {  
    $amilNo = $_SESSION['AmilNo'];  

    // استعلام لاسترداد حالة الفاتورة  
    $stmt = $pdo->prepare("SELECT done FROM Cart WHERE AmilNo = ?");  
    $stmt->execute([$amilNo]);  
    $invoice = $stmt->fetch(PDO::FETCH_ASSOC); // استخدم FETCH_ASSOC للحصول على مصفوفة مرتبطة  

    // تعيين حالة الفاتورة  
    if ($invoice !== false) {  
        $invoiceStatus = (int)$invoice['done']; // تحويل القيمة إلى عدد صحيح  
    } else {  
        $invoiceStatus = 0; // إذا لم توجد فاتورة، اعتبرها مغلقة (0)  
    }  
} else {  
    $invoiceStatus = 0; // إذا لم يكن المستخدم مسجلاً للدخول، اعتبر الفاتورة مغلقة  
}  
?>  

<!DOCTYPE html>  
<html lang="ar">  
<head>  
    <meta charset="UTF-8">  
    <title>المتجر الإلكتروني</title>  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">  
    <link rel="stylesheet" href="assets/css/custom.css">   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  
    <style>  
        .navbar {  
            position: fixed;  
            top: 0;  
            width: 100%;  
            z-index: 1000;  
        }  
        
        body {  
            margin-top: 70px;  
        }  

        /* ألوان خلفية الفاتورة */  
        .invoice-open {  
            background-color: green; /* لون الخلفية عندما تكون الفاتورة مفتوحة */  
            color: white; /* لون النص */  
        }  

        .invoice-closed {  
            background-color: red; /* لون الخلفية عندما تكون الفاتورة مغلقة */  
            color: white; /* لون النص */  
        }  
    </style>  
</head>  
<body dir="rtl">  
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">  
    <div class="container">  
        <a class="navbar-brand" href="#">المتجر الإلكتروني</a>  
        <span class="nav-link <?php echo $invoiceStatus === 0 ? 'invoice-open' : 'invoice-closed'; ?>" id="total-amount">  
            <?php echo isset($_SESSION['totalAmount']) ? $_SESSION['totalAmount'] . ' دينار' : '0 دينار'; ?>  
        </span> <!-- إجمالي الفاتورة -->  
        <span class="nav-link" id="total-items"><?php echo isset($_SESSION['totalItems']) ? $_SESSION['totalItems'] . ' وحدة' : '0 صنف'; ?></span> <!-- عدد الأصناف -->  
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="تبديل التنقل">  
            <span class="navbar-toggler-icon"></span>  
        </button>  
        <div class="collapse navbar-collapse flex-row-reverse" id="navbarNav">  
            <ul class="navbar-nav">  
                <?php if (isset($_SESSION['AmilNo'])): ?>  
                    <li class="nav-item">  
                        <a class="nav-link" href="index.php?controller=main&action=index">الرئيسية</a>  
                    </li>  
                    <li class="nav-item">  
                        <a class="nav-link" href="index.php?controller=store&action=index">المتجر</a>  
                    </li>  
                    <li class="nav-item">  
                        <a class="nav-link" href="index.php?controller=invoice&action=index">فاتورتي</a>  
                    </li>  
                    <li class="nav-item">  
                        <a class="nav-link" href="index.php?controller=login&action=logout">تسجيل الخروج</a>  
                    </li>  
                <?php else: ?>  
                    <li class="nav-item">  
                        <a class="nav-link" href="index.php">تسجيل الدخول</a>  
                    </li>  
                <?php endif; ?>  
            </ul>  
        </div>  
    </div>  
</nav>  

<div class="container mt-4">  
    <!-- محتوى الصفحة -->  
</div>  

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>  
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>  
</body>  
</html>