
<?php include 'views/layout/header.php'; ?>
<div class="container">
    <p>.</p>
    <p>.</p>
    <h2>مرحبًا، <?php echo $_SESSION['AmilName']; ?></h2>
    <p>رصيدك الحالي: <?php echo $_SESSION['NawRasid']; ?> دينار</p>
</div>
<?php include 'views/layout/footer.php'; ?>
