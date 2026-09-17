<?php
require_once 'functions.php';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $name=trim($_POST['name']??'');$email=trim($_POST['email']??'');$subject=trim($_POST['subject']??'');$message=trim($_POST['message']??'');
  if($name && filter_var($email,FILTER_VALIDATE_EMAIL) && $message){
    $s=$pdo->prepare("INSERT INTO contacts(name,email,subject,message) VALUES(?,?,?,?)");$s->execute([$name,$email,$subject,$message]);
    $_SESSION['flash']=['type'=>'success','message'=>'Your message has been submitted.'];redirect('contact.php');
  } else $error='Please provide a valid name, email and message.';
}
$pageTitle='Contact Us';require 'header.php';
?>
<h1>Contact Us</h1>
<div class="row g-4"><div class="col-lg-5"><div class="form-card"><h4>Contact Information</h4><p>📍 BookVerse, Ahmedabad, Gujarat</p><p>☎ +91 90000 00000</p><p>✉ support@bookverse.local</p><p>🕘 Mon–Sat, 10:00 AM–6:00 PM</p></div></div>
<div class="col-lg-7"><div class="form-card"><?php if(!empty($error)):?><div class="alert alert-danger"><?=e($error)?></div><?php endif;?><form method="post" class="row g-3">
<div class="col-md-6"><label class="form-label">Name</label><input class="form-control" name="name" required></div><div class="col-md-6"><label class="form-label">Email</label><input class="form-control" type="email" name="email" required></div><div class="col-12"><label class="form-label">Subject</label><input class="form-control" name="subject"></div><div class="col-12"><label class="form-label">Message</label><textarea class="form-control" name="message" rows="5" required></textarea></div><div><button class="btn btn-dark">Send Message</button></div></form></div></div></div>
<?php require 'footer.php'; ?>
