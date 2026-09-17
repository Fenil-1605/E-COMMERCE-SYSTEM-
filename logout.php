<?php
require_once 'config.php';
unset($_SESSION['user_id'],$_SESSION['user_name'],$_SESSION['user_email']);
$_SESSION['flash']=['type'=>'success','message'=>'You have been logged out.'];
header('Location: index.php'); exit;
