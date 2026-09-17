<?php
require_once 'functions.php';
if(isLoggedIn()) redirect('index.php');
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $name=trim($_POST['name']??'');$email=trim($_POST['email']??'');$mobile=trim($_POST['mobile']??'');$pass=$_POST['password']??'';$confirm=$_POST['confirm_password']??'';$address=trim($_POST['address']??'');
  if(!$name || !filter_var($email,FILTER_VALIDATE_EMAIL) || strlen($pass)<6 || $pass!==$confirm) $error='Please fill all fields correctly. Password must be at least 6 characters and match confirmation.';
  else {
    try{$s=$pdo->prepare("INSERT INTO users(name,email,mobile,password,address) VALUES(?,?,?,?,?)");$s->execute([$name,$email,$mobile,password_hash($pass,PASSWORD_DEFAULT),$address]);$_SESSION['flash']=['type'=>'success','message'=>'Registration successful. Please login.'];redirect('login.php');}
    catch(PDOException $e){$error='This email is already registered.';}
  }
}
$pageTitle='Register';require 'header.php';
?>
<div class="narrow mx-auto"><div class="form-card"><h1>Create Account</h1><?php if($error):?><div class="alert alert-danger"><?=e($error)?></div><?php endif;?>
<form method="post" class="row g-3">
<div class="col-md-6"><label class="form-label">Name *</label><input class="form-control" name="name" value="<?=e(old('name'))?>" required></div>
<div class="col-md-6"><label class="form-label">Email *</label><input class="form-control" type="email" name="email" value="<?=e(old('email'))?>" required></div>
<div class="col-md-6"><label class="form-label">Mobile *</label><input class="form-control" name="mobile" required></div>
<div class="col-12"><label class="form-label">Address *</label><textarea class="form-control" name="address" required></textarea></div>
<div class="col-md-6"><label class="form-label">Password *</label><input class="form-control" type="password" name="password" required></div>
<div class="col-md-6"><label class="form-label">Confirm Password *</label><input class="form-control" type="password" name="confirm_password" required></div>
<div><button class="btn btn-dark">Register</button></div>
</form></div></div>
<?php require 'footer.php'; ?>
