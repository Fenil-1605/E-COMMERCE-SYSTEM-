<?php
require_once 'functions.php'; requireLogin();
$id=(int)($_GET['id']??0);
$s=$pdo->prepare("SELECT * FROM orders WHERE id=? AND user_id=?");$s->execute([$id,$_SESSION['user_id']]);$o=$s->fetch();
if(!$o) redirect('orders.php');
$s=$pdo->prepare("SELECT * FROM order_items WHERE order_id=?");$s->execute([$id]);$items=$s->fetchAll();
$pageTitle='Order Details';require 'header.php';
?>
<h1>Order #<?=e($o['id'])?></h1>
<div class="row g-4"><div class="col-lg-8"><div class="form-card">
<?php foreach($items as $i): ?><div class="d-flex justify-content-between border-bottom py-3"><div><strong><?=e($i['product_name'])?></strong><div class="text-muted">₹<?=number_format($i['price'],2)?> × <?=$i['quantity']?></div></div><strong>₹<?=number_format($i['subtotal'],2)?></strong></div><?php endforeach; ?>
<div class="d-flex justify-content-between fs-5 pt-3"><strong>Total</strong><strong>₹<?=number_format($o['total_amount'],2)?></strong></div>
</div></div><div class="col-lg-4"><div class="summary-box"><h5>Order Information</h5><p><strong>Status:</strong> <?=e($o['order_status'])?></p><p><strong>Payment:</strong> <?=e($o['payment_method'])?></p><p><strong>Payment Status:</strong> <?=e($o['payment_status'])?></p><hr><p><strong>Shipping:</strong><br><?=e($o['shipping_address'])?><br><?=e($o['city'])?>, <?=e($o['state'])?> - <?=e($o['pincode'])?></p></div></div></div>
<?php require 'footer.php'; ?>
