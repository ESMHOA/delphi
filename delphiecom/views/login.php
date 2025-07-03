<?php include 'views/layout/header.php'; ?>  

<style>  
    body {  
        background-color: #f8f9fa; /* لون خلفية فاتح */  
    }  
    .card {  
        margin-top: 50px;  
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* ظل خفيف للبطاقة */  
    }  
    .card-header {  
        background-color: #007bff; /* لون خلفية العنوان */  
        color: white;  
    }  
    .btn-primary {  
        background-color: #007bff;  
        border: none;  
        transition: background-color 0.3s ease-in-out; /* تأثير الانسيابية */  
    }  
    .btn-primary:hover {  
        background-color: #0056b3; /* تغير لون الزر عند التحويم */  
    }  
    .form-control {  
        border-radius: 0.25rem; /* زوايا مستديرة */  
    }  
</style>  

<div class="container">  
    <div class="row justify-content-center">  
        <div class="col-md-6">  
            <div class="card">  
                <div class="card-header text-center">  
                    <h4>تسجيل الدخول</h4>  
                </div>  
                <div class="card-body">  
                    <?php if (isset($error)): ?>  
                        <div class="alert alert-danger text-center"><?php echo $error; ?></div>  
                    <?php endif; ?>  
                    <form action="index.php?controller=login&action=authenticate" method="POST">  
                        <div class="form-group">  
                            <label for="AmilNo">رقم العميل:</label>  
                            <input type="text" class="form-control" id="AmilNo" name="AmilNo" required>  
                        </div>  
                        <div class="form-group">  
                            <label for="Passworda">كلمة السر:</label>  
                            <input type="password" class="form-control" id="Passworda" name="Passworda" required>  
                        </div>  
                        <p></p>  
                        <button type="submit" class="btn btn-primary btn-block">دخول</button>  
                    </form>  
                </div>  
            </div>  
        </div>  
    </div>  
</div>  

<?php include 'views/layout/footer.php'; ?>