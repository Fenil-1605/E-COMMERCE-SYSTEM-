<?php
require_once 'functions.php';
requireLogin();
$oid=(int)($_GET['order']??0);
$s=$pdo->prepare("SELECT * FROM orders WHERE id=? AND user_id=?"); $s->execute([$oid,$_SESSION['user_id']]); $order=$s->fetch();
if(!$order) redirect('orders.php');
if($_SERVER['REQUEST_METHOD']==='POST'){ redirect('success.php?order='.$oid); }
$pageTitle='Payment';
require 'header.php';
?>
<div class="narrow mx-auto">
<h1>Payment</h1><div class="form-card text-center">
<div class="payment-icon">💵</div><h3>Cash on Delivery</h3>
<p class="text-muted">No online payment is required for this university project.</p>
<h4>Order #<?=e($order['id'])?> — ₹<?=number_format($order['total_amount'],2)?></h4>
<form method="post"><button class="btn btn-dark btn-lg mt-3">Confirm Cash on Delivery</button></form>
</div></div>
<?php require 'footer.php'; ?>
