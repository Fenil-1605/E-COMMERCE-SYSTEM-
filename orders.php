<?php
require_once 'functions.php'; requireLogin();
$s=$pdo->prepare("SELECT * FROM orders WHERE user_id=? ORDER BY created_at DESC"); $s->execute([$_SESSION['user_id']]); $orders=$s->fetchAll();
$pageTitle='Order History'; require 'header.php';
?>
<h1>Order History</h1><p class="text-muted">Your previous BookVerse orders.</p>
<div class="table-responsive"><table class="table align-middle">
<thead><tr><th>Order ID</th><th>Date</th><th>Products</th><th>Total</th><th>Payment</th><th>Status</th><th></th></tr></thead>
<tbody>
<?php foreach($orders as $o): $q=$pdo->prepare("SELECT SUM(quantity) FROM order_items WHERE order_id=?");$q->execute([$o['id']]);$count=$q->fetchColumn(); ?>
<tr><td>#<?=e($o['id'])?></td><td><?=e(date('d M Y',strtotime($o['created_at'])))?></td><td><?=e($count)?></td><td>₹<?=number_format($o['total_amount'],2)?></td><td><?=e($o['payment_method'])?></td><td><span class="status"><?=e($o['order_status'])?></span></td><td><a href="order_details.php?id=<?=$o['id']?>" class="btn btn-sm btn-dark">Details</a></td></tr>
<?php endforeach; ?>
<?php if(!$orders): ?><tr><td colspan="7" class="text-center py-5">No orders yet.</td></tr><?php endif; ?>
</tbody></table></div>
<?php require 'footer.php'; ?>
