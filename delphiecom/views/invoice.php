<?php include 'views/layout/header.php'; ?>  

<style>  
    body {  
        background-color: #f4f7fa; /* لون خلفية فاتح */  
    }  
    .table th {  
        background-color: #007bff; /* لون خلفية العناوين */  
        color: white;  
    }  
    .table td {  
        background-color: #ffffff; /* لون خلفية الصفوف */  
        border-color: #dee2e6;  
    }  
    .table tbody tr:nth-child(even) {  
        background-color: #f2f6fc; /* تظليل بديل خفيف للصفوف */  
    }  
    .btn-custom {  
        transition: background-color 0.3s ease-in-out; /* تأثير الانسيابية */  
    }  
    .btn-custom:hover {  
        background-color: #0056b3; /* تغير لون الزر عند التحويم */  
        color: white;  
    }  
</style>  

<p> .</p>  
<p>.</p>  
<div class="container">  
    <h2 class="mb-4">فاتورتي</h2>  
    <?php if ($cartItems): ?>  
        <div class="text-right mb-3 d-flex justify-content-between">  
            <form action="index.php?controller=invoice&action=completePurchase" method="POST" class="w-50">  
                <button type="submit" class="btn btn-danger w-100 btn-custom" <?php echo $invoiceStatus === 1 ? 'disabled' : ''; ?>>قفل السلة</button>  
            </form>  
            <form action="index.php?controller=invoice&action=openCart" method="POST" class="w-50">  
                <button type="submit" class="btn btn-success w-100 btn-custom" <?php echo $invoiceStatus === 0 ? 'disabled' : ''; ?>>فتح السلة</button>  
            </form>  
        </div>  

        <table class="table table-bordered">  
            <thead>  
                <tr>  
                    <th style="width: 50px;">#</th>  
                    <th>الصنف</th>  
                    <th style="width: 300px;">الكمية</th>  
                    <th>السعر</th>  
                    <th>الإجمالي</th>  
                    <th>التحكم</th>  
                </tr>  
            </thead>  
            <tbody>  
                <?php   
                $total = 0;   
                $totalQ = 0;  
                $serialNumber = 1;  
                ?>  
                <?php foreach ($cartItems as $item): ?>  
                    <tr>  
                        <td><?php echo $serialNumber++; ?></td>  
                        <td colspan="5" style="color: #0056b3; font-weight: bold; background-color: #e7f5ff;"><?php echo $item['SenfDisc']; ?></td>  
                    </tr>  
                    <tr>  
                        <td></td>  
                        <td></td>  
                        <td>  
                            <form action="index.php?controller=invoice&action=updateItem" method="POST" class="form-inline">  
                                <input type="hidden" name="SenfNo" value="<?php echo $item['SenfNo']; ?>">  
                                <div class="input-group">  
                                    <input type="number" name="Q" value="<?php echo $item['Q']; ?>" min="1" class="form-control" style="width:80px;" <?php echo $invoiceStatus === 1 ? 'disabled' : ''; ?>>  
                                    <div class="input-group-append">  
                                        <button type="submit" class="btn btn-primary btn-custom" <?php echo $invoiceStatus === 1 ? 'disabled' : ''; ?>>حفظ</button>  
                                    </div>  
                                </div>  
                            </form>  
                        </td>  
                        <td><?php echo $item['Price']; ?> دينار</td>  
                        <td><?php echo $item['Q'] * $item['Price']; ?> دينار</td>  
                        <td>  
                            <a href="#" class="btn btn-danger btn-sm btn-custom" onclick="confirmDelete('<?php echo $item['SenfNo']; ?>')" <?php echo $invoiceStatus === 1 ? 'style="pointer-events: none; opacity: 0.5;"' : ''; ?>>حذف</a>  
                        </td>  
                    </tr>  
                    <?php   
                    $total  += $item['Q'] * $item['Price'];   
                    $totalQ += $item['Q'];   
                    ?>  
                <?php endforeach; ?>  
                <tr>  
                    <th colspan="2" class="text-right">الإجمالي الكلي</th>  
                    <th colspan="2"><?php echo $totalQ; ?> وحدة</th>  
                    <th colspan="3"><?php echo $total; ?> دينار</th>  
                </tr>  
            </tbody>  
        </table>  
    <?php else: ?>  
        <p class="alert alert-info">سلة المشتريات فارغة.</p>  
    <?php endif; ?>  
</div>  

<script>  
function confirmDelete(senfNo) {  
    if (confirm("هل ترغب بالفعل في حذف هذا الصنف؟")) {  
        window.location.href = "index.php?controller=invoice&action=deleteItem&SenfNo=" + senfNo;  
    }  
}  
</script>  

<?php include 'views/layout/footer.php'; ?>