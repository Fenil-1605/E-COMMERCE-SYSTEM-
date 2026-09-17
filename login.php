<?php
require_once 'functions.php';
if(isLoggedIn()) redirect('index.php');
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $email=trim($_POST['email']??'');$password=$_POST['password']??'';
  $s=$pdo->prepare("SELECT * FROM users WHERE email=? AND status=1");$s->execute([$email]);$u=$s->fetch();
  if($u && password_verify($password,$u['password'])){
    session_regenerate_id(true);$_SESSION['user_id']=$u['id'];$_SESSION['user_name']=$u['name'];$_SESSION['user_email']=$u['email'];redirect('index.php');
  } else $error='Invalid email or password.';
}
$pageTitle='Login';require 'header.php';
?>
<div class="narrow mx-auto"><div class="form-card"><h1>Customer Login</h1><p class="text-muted">Login to place orders and view your order history.</p><?php if($error):?><div class="alert alert-danger"><?=e($error)?></div><?php endif;?>
<form method="post"><label class="form-label">Email</label><input class="form-control mb-3" type="email" name="email" required><label class="form-label">Password</label><input class="form-control mb-3" type="password" name="password" required><button class="btn btn-dark w-100">Login</button></form>
<p class="text-center mt-3 mb-0">
  New customer? <a href="register.php">Create an account</a>
</p>

<hr class="my-4">

<div class="text-center">
  <p class="mb-2">Are you an administrator?</p>
  <a href="admin/login.php" class="btn btn-outline-dark w-100">
    Admin Login
  </a>
</div></div></div>
<?php require 'footer.php'; ?>
