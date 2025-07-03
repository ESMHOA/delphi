</div> <!-- نهاية container -->  
<!-- تضمين jQuery و Bootstrap JS -->  
<script src="assets/js/jquery.min.js"></script>  
<script src="assets/js/bootstrap.bundle.min.js"></script>  

<script>  
$(document).ready(function() {  
    // تحديث القيم في شريط التنقل عند تحميل الصفحة  
    updateNavbarTotals();  

    $('.add-to-cart-form').on('submit', function(e) {  
        e.preventDefault(); // منع إعادة تحميل الصفحة  

        var form = $(this);  
        var senfNo = form.data('senfno');  
        var quantity = form.find('input[name="Q"]').val();  

        $.ajax({  
            url: 'index.php?controller=store&action=addToCart&SenfNo=' + senfNo,  
            type: 'POST',  
            data: { Q: quantity },  
            success: function(response) {  
                var data = JSON.parse(response); // تحليل الاستجابة JSON  
                console.log(data); // تسجيل الاستجابة في وحدة التحكم  
                if (data.success) {  
                    // تحديث قيمة الفاتورة في شريط التنقل  
                    $('#total-amount').text(data.totalAmount + ' دينار'); // تأكد من وجود عنصر بهذا المعرف في شريط التنقل  
                    $('#total-items').text(data.totalItems + ' وحدة'); // Total items  
                } else {  
                    console.error(data.message); // تسجيل الخطأ في وحدة التحكم  
                }  
            },  
            error: function() {  
                console.error('حدث خطأ أثناء إضافة العنصر إلى السلة.');  
            }  
        });  
    });  

    function updateNavbarTotals() {  
        $.ajax({  
            url: 'index.php?controller=cart&action=getTotals', // تأكد من وجود هذا الرابط في التطبيق الخاص بك  
            type: 'GET',  
            success: function(response) {  
                var data = JSON.parse(response);  
                $('#total-amount').text(data.totalAmount + ' دينار');  
                $('#total-items').text(data.totalItems + ' صنف');  
            },  
            error: function() {  
                console.error('حدث خطأ أثناء تحديث القيم في شريط التنقل.');  
            }  
        });  
    }  
});  
</script>  
</body>  
</html>