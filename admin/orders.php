<?php
require_once '../functions.php';requireAdmin();$pageTitle='Orders';
if($_SERVER['REQUEST_METHOD']==='POST'){$id=(int)$_POST['id'];$status=$_POST['order_status'];$allowed=['Pending','Confirmed','Processing','Shipped','Delivered','Cancelled'];if(in_array($status,$allowed,true)){$s=$pdo->prepare("UPDATE orders SET order_status=? WHERE id=?");$s->execute([$status,$id]);$_SESSION['flash']=['type'=>'success','message'=>'Order status updated.'];}redirect('orders.php');}
$rows=$pdo->query("SELECT o.*,u.name AS account_name FROM orders o JOIN users u ON u.id=o.user_id ORDER BY o.created_at DESC")->fetchAll();require 'header.php';
?>
<h1>Orders</h1><div class="table-responsive"><table class="table bg-white align-middle"><thead><tr><th>ID</th><th>Customer</th><th>Date</th><th>Total</th><th>Payment</th><th>Status</th><th>Update</th></tr></thead><tbody>
<?php foreach($rows as $r):?><tr><td>#<?=$r['id']?></td><td><?=e($r['customer_name'])?><br><small><?=e($r['email'])?></small></td><td><?=e(date('d M Y, h:i A',strtotime($r['created_at'])))?></td><td>₹<?=number_format($r['total_amount'],2)?></td><td><?=e($r['payment_method'])?></td><td><span class="status"><?=e($r['order_status'])?></span></td><td><form method="post" class="d-flex"><input type="hidden" name="id" value="<?=$r['id']?>"><select class="form-select form-select-sm" name="order_status"><?php foreach(['Pending','Confirmed','Processing','Shipped','Delivered','Cancelled'] as $st):?><option <?=$r['order_status']===$st?'selected':''?>><?=$st?></option><?php endforeach;?></select><button class="btn btn-sm btn-dark ms-1">Save</button></form></td></tr><?php endforeach;?>
</tbody></table></div>
<?php require 'footer.php';?>
