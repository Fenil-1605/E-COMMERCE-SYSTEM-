<?php
require_once 'functions.php';
requireLogin();
$oid=(int)($_GET['order']??0);
$s=$pdo->prepare("SELECT * FROM orders WHERE id=? AND user_id=?"); $s->execute([$oid,$_SESSION['user_id']]); $order=$s->fetch();
if(!$order) redirect('orders.php');
$s=$pdo->prepare("SELECT * FROM order_items WHERE order_id=?"); $s->execute([$oid]); $items=$s->fetchAll();
$pageTitle='Order Successful';
require 'header.php';
?>
<div class="success-box text-center">
<div class="success-icon">✓</div><h1>Order Placed Successfully!</h1>
<p>Thank you, <?=e($order['customer_name'])?>. Your BookVerse order has been received.</p>
<div class="order-card text-start mx-auto">
<div class="d-flex justify-content-between"><strong>Order ID</strong><span>#<?=e($order['id'])?></span></div>
<div class="d-flex justify-content-between"><strong>Order Date</strong><span><?=e(date('d M Y, h:i A',strtotime($order['created_at'])))?></span></div>
<div class="d-flex justify-content-between"><strong>Payment</strong><span><?=e($order['payment_method'])?></span></div><hr>
<?php foreach($items as $i): ?><div class="d-flex justify-content-between py-1"><span><?=e($i['product_name'])?> × <?=$i['quantity']?></span><span>₹<?=number_format($i['subtotal'],2)?></span></div><?php endforeach; ?>
<hr><div class="d-flex justify-content-between fs-5"><strong>Total</strong><strong>₹<?=number_format($order['total_amount'],2)?></strong></div>
</div>
<div class="mt-4"><a href="products.php" class="btn btn-dark">Continue Shopping</a> <a href="orders.php" class="btn btn-outline-dark">Order History</a></div>
</div>
<?php require 'footer.php'; ?>
