<?php  
include 'views/layout/header.php';   
?>  

<div class="container">  
    <h2 class="mb-4">المتجر</h2>  
    <form method="GET" action="index.php" class="mb-4">  
        <input type="hidden" name="controller" value="store">  
        <input type="hidden" name="action" value="index">  
        <div class="input-group">  
            <input type="text" name="search" class="form-control" placeholder="بحث عن منتج..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">  
            <div class="input-group-append">  
                <button class="btn btn-primary" type="submit">بحث</button>  
                <a href="index.php?controller=store&action=index" class="btn btn-secondary">مسح</a>  
            </div>  
        </div>  
    </form>  

    <?php   
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

    if ($invoiceStatus === 1): ?>  
        <div class="alert alert-danger">  
            الفاتورة مقفلة، لا يمكنك إضافة أو تعديل المنتجات.  
        </div>  
    <?php else: ?>  
        <div class="row">  
            <?php if ($items): ?>  
                <?php foreach ($items as $item): ?>  
                    <div class="col-md-4">  
                        <div class="card mb-4">  
                            <?php  
                                $imagePath = 'images/p' . $item['SenfNo'] . '.jpg';  
                                if (!file_exists($imagePath)) {  
                                    $imagePath = 'images/000.jpg';  
                                }  
                            ?>  
                            <img src="<?php echo $imagePath; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($item['SenfDisc']); ?>">  
                            <div class="card-body">  
                                <h5 class="card-title"><?php echo htmlspecialchars($item['SenfDisc']); ?></h5>  
                                <p class="card-text">السعر: <span class="text-success"><?php echo $item['Price']; ?></span> دينار</p>  
                                <p class="card-text">الوحدة: <?php echo $item['Unit']; ?></p>  
                                <form class="add-to-cart-form" data-senfno="<?php echo $item['SenfNo']; ?>" method="POST">  
                                    <div class="form-group">  
                                        <label for="Q">الكمية:</label>  
                                        <input type="number" name="Q" value="1" min="1" class="form-control" <?php echo $invoiceStatus === 1 ? 'disabled' : ''; ?>>  
                                    </div>  
                                    <p></p>
                                    <button type="submit" class="btn btn-success btn-block" <?php echo $invoiceStatus === 1 ? 'disabled' : ''; ?>>إضافة إلى السلة</button>  
                                </form>  
                            </div>  
                        </div>  
                    </div>  
                <?php endforeach; ?>  
            <?php else: ?>  
                <p class="alert alert-info">لا توجد منتجات مطابقة لعملية البحث.</p>  
            <?php endif; ?>  
        </div>  
    <?php endif; ?>  
</div>  

<script src="assets/js/jquery.min.js"></script>  
<script src="assets/js/bootstrap.bundle.min.js"></script>  

<?php include 'views/layout/footer.php'; ?>