<?php
require "db.php"; require "auth.php";
$err=""; if($_SERVER['REQUEST_METHOD']=='POST'){
  $e=trim($_POST['email']); $p=$_POST['password'];
  $stmt=$pdo->prepare("SELECT * FROM users WHERE email=?"); $stmt->execute([$e]); $u=$stmt->fetch();
  if($u && password_verify($p,$u['password_hash'])){ $_SESSION['user_id']=$u['id']; $_SESSION['username']=$u['username']; header("Location: index.php"); exit(); }
  else $err="Invalid email or password";
}
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login - MindVault</title><link rel="stylesheet" href="assets/css/style.css"></head><body>
<div class="login-wrap"><form method="POST" class="card login-card"><h2>Welcome back</h2><p style="color:var(--muted);margin:6px 0 16px">Login to MindVault</p><?php if($err) echo "<div class='alert alert-error'>$err</div>";?><input name="email" class="input" placeholder="Email" type="email" required style="margin-bottom:10px"><input name="password" class="input" placeholder="Password" type="password" required style="margin-bottom:14px"><button class="btn" style="width:100%">Login</button><p style="margin-top:12px;color:var(--muted);font-size:13px">No account? <a href="register.php" style="color:var(--accent2)">Create one</a></p></form></div></body></html>
