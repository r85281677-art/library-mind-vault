<?php
require "db.php"; require "auth.php";
$err=""; if($_SERVER['REQUEST_METHOD']=='POST'){
  $u=trim($_POST['username']); $e=trim($_POST['email']); $p=$_POST['password'];
  if(strlen($u)<3) $err="Username too short";
  else if(!filter_var($e,FILTER_VALIDATE_EMAIL)) $err="Invalid email";
  else if(strlen($p)<6) $err="Password must be 6+ chars";
  else {
    $hash=password_hash($p,PASSWORD_DEFAULT);
    try{ $stmt=$pdo->prepare("INSERT INTO users (username,email,password_hash) VALUES (?,?,?)"); $stmt->execute([$u,$e,$hash]); $_SESSION['user_id']=$pdo->lastInsertId(); $_SESSION['username']=$u; header("Location: index.php"); exit(); }
    catch(PDOException $ex){ $err="Username or email already exists"; }
  }
}
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Register - MindVault</title><link rel="stylesheet" href="style.css"></head><body>
<div class="login-wrap"><form method="POST" class="card login-card"><h2>Create account</h2><p style="color:var(--muted);margin:6px 0 16px">Join MindVault</p><?php if($err) echo "<div class='alert alert-error'>$err</div>";?><input name="username" class="input" placeholder="Username" required style="margin-bottom:10px"><input name="email" class="input" placeholder="Email" type="email" required style="margin-bottom:10px"><input name="password" class="input" placeholder="Password" type="password" required style="margin-bottom:14px"><button class="btn" style="width:100%">Sign Up</button><p style="margin-top:12px;color:var(--muted);font-size:13px">Have account? <a href="login.php" style="color:var(--accent2)">Login</a></p></form></div></body></html>
